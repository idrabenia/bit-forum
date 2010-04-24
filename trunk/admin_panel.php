<?php

/**
 * File contain functions for processing requests
 * to admin panel.
 * @author Ilya Drobenya
 */

require_once('common.php');
require_once('includes/authorization.php');


/** Path to main administrator panel template */
define('ADMIN_PANEL_PATH', 'templates/Admin/admin_panel.tpl');

$user = User::getInstance(); 
if (!$user->isAdmin()) {
	echo 'Error 404: Page Not Found';
	exit();
}

modify_config();
echo make_admin_panel();

/**
 * Function fetch from database configuration parameters 
 * and create configurations page.
 * @param db_connect Used connection to database.
 * @return Administrator panel in HTML. 
 */
function make_admin_panel() {
    global $db_link;
    // Connect to database
    $db_connect = $db_link;
	
    // Load template
    $template = file_get_contents(ADMIN_PANEL_PATH);
    $main_tpl = file_get_contents(MAIN_TPL_PATH);
    
    // Fetch parameters from database 
    $results = mysql_query(
       "SELECT `param_name`, `param_value` "
       . "FROM `config` ", 
       $db_connect)
       or die('Could not fetch data from database');

    $parameters = array();
    while ($row = mysql_fetch_assoc($results)) {
        $parameters[ $row['param_name'] ] = $row['param_value'];
    }
    
    // Insert parameters into template
    $holders = array(
        '{TITLE}' => 'Admin Panel',
        '{ROOT_PATH}' => ROOT_PATH,
        '{MIN_LOGIN_SIZE}' => $parameters['MIN_LOGIN_SIZE'],
        '{MAX_LOGIN_SIZE}' => $parameters['MAX_LOGIN_SIZE'],
        '{MAX_MSG_SIZE}' => $parameters['MAX_MESSAGE_SIZE'],
        '{MIN_PASSWORD_SIZE}' => $parameters['MIN_PASSWORD_SIZE'],
        '{MAX_PASSWORD_SIZE}' => $parameters['MAX_PASSWORD_SIZE'],
            
        // Set account activation
        '{NO_ACCOUNT_ACTIVATION}' => 
            ($parameters['ACCOUNT_ACTIVATION'] 
                === 'NO_ACCOUNT_ACTIVATION')?
                'checked="checked"' : '', 
        '{DISABLED_ACCOUNT_ACTIVATION}' => 
            ($parameters['ACCOUNT_ACTIVATION'] 
                === 'DISABLED_ACCOUNT_ACTIVATION')?
                'checked="checked"' : '', 
        '{EMAIL_ACCOUNT_ACTIVATION}' => 
            ($parameters['ACCOUNT_ACTIVATION'] 
                === 'EMAIL_ACCOUNT_ACTIVATION')?
                'checked="checked"' : '',
                
        '{PASSW_ACTION_TIME}' => $parameters['PASSW_ACTION_TIME'],
                
        // Set password complexity
        '{NO_PASSW_COMPLEX}' => ($parameters['PASSW_COMPLEXITY'] 
                === 'NO_PASSW_COMPLEX')? 'selected="true"' : '',
        '{REGISTER_PASSW_COMPLEX}' => ($parameters['PASSW_COMPLEXITY'] 
                === 'REGISTER_PASSW_COMPLEX')? 'selected="true"' : '',
        '{DIGIT_PASSW_COMPLEX}' => ($parameters['PASSW_COMPLEXITY'] 
                === 'DIGIT_PASSW_COMPLEX')? 'selected="true"' : '',
        '{DIGIT_REGISTER_PASSW_COMPLEX}' => 
                ($parameters['PASSW_COMPLEXITY'] 
                === 'DIGIT_REGISTER_PASSW_COMPLEX')
                ? 'selected="true"' : '',

        // Set enabling avatars
        '{ENABLED_AVATARS}' => ($parameters['ENABLED_AVATARS'] 
                === 'ENABLED_AVATARS')? 'checked="true"' : '',
        '{DISABLED_AVATARS}' => ($parameters['ENABLED_AVATARS'] 
                === 'DISABLED_AVATARS')? 'checked="true"' : '',
                
        '{IMAGES_PATH}' => $parameters['IMAGES_PATH'],
        '{ADMINS_EMAIL}' => $parameters['ADMINS_EMAIL']
    );    
        
    foreach ($holders as $cur_holder => $cur_value) {
        $template = str_replace($cur_holder,
            $cur_value, $template);
        $main_tpl = str_replace($cur_holder, $cur_value,
            $main_tpl);
    }
    
    $main_tpl = str_replace('{BODY}', $template, $main_tpl);
    return $main_tpl;
} // show_admin_panel


/**
 * Function save in database received parameters. 
 * @param $db_connect Used connection to database.
 */
function modify_config() {
	
	// Validate and save received data
    $fields_patterns = array(
        'login_size_min' => "/^(\d){1,2}$/", 
        'login_size_max' => "/^(\d){1,2}$/", 
        'password_size_max' => "/^(\d){1,2}$/",
		'password_size_min' => "/^(\d){1,2}$/",
		'password_action_time' => "/^(\d){1,3}$/",
		'image_store_path' => "/^([^'])*$/",
		'admin_email' => "/^([A-z0-9_\-]+\.)*[A-z0-9_\-]+"
	       . "@([A-z0-9][A-z0-9\-]*[A-z0-9]\.)+[A-z]{2,4}$/",
        'account_activation' => "/^(NO_ACCOUNT_ACTIVATION"
	       . "|DISABLED_ACCOUNT_ACTIVATION"
	       . "|EMAIL_ACCOUNT_ACTIVATION)$/",
	    'avatar_upload' => "/^(ENABLED_AVATARS|DISABLED_AVATARS)$/",
	    'password_complexity' => "/^(NO_PASSW_COMPLEX"
	       . "|REGISTER_PASSW_COMPLEX|DIGIT_PASSW_COMPLEX"
	       . "|DIGIT_REGISTER_PASSW_COMPLEX)$/",
	    'max_message_size' => "/^(\d){1,4}$/"
	);
	$fields_aliases = array(
	   'login_size_min' => 'MIN_LOGIN_SIZE', 
	   'login_size_max' => 'MAX_LOGIN_SIZE', 
	   'password_size_max' => 'MAX_PASSWORD_SIZE',
	   'password_size_min' => 'MIN_PASSWORD_SIZE',
	   'password_action_time' => 'PASSW_ACTION_TIME',
	   'image_store_path' => 'IMAGES_PATH',
	   'admin_email' => 'ADMINS_EMAIL',
	   'account_activation' => 'ACCOUNT_ACTIVATION',
	   'avatar_upload' => 'ENABLED_AVATARS', 
	   'password_complexity' => 'PASSW_COMPLEXITY',
	   'max_message_size' => 'MAX_MESSAGE_SIZE'
	);
	
	foreach ($fields_patterns as $name => $pattern) {
	    if ( is_post_param_correct($name, $pattern) ) {
	        update_config($fields_aliases[$name], 
	           $_POST[$name]);
	    }
	}
} // input_parameters


/**
 * Function validate POST-parameter.
 * @param $param_name Name of parameter.
 * @param $pattern Regular expression of correct 
 *        parameter.
 * @return if parameter set and correct 
 *         function return TRUE, otherwise FALSE. 
 */
function is_post_param_correct($param_name, $pattern) {
    if ( !isset($_POST[$param_name]) ) {  
        return FALSE;
    }
    if ( preg_match( $pattern, $_POST[$param_name] ) !== 1 ) {
        return FALSE;            
    } 
    return TRUE;
} // is_post_param_correct


/** 
 * Function for update configuration.
 * @param $name Config parameter name.
 * @param $value New config parameter value.
 * @param $db_connect Connection to database.
 */
function update_config($name, $value) {
	global $db_link;
    $db_connect = $db_link;	
    
    $name = mysql_escape_string($name);
    $value = mysql_escape_string($value);
    mysql_query(
        "UPDATE `config` "
        . "SET `param_value`='$value' "
        . "WHERE `param_name`='$name' ",
        $db_connect );
} // update_config


?>