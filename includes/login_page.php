<?php

/**
 * File content functions for represent
 * login page.
 */

require_once('common.php');
require_once('authorization.php');

define('LOGIN_TPL_PATH', 'templates/login.tpl');
define('MAIN_TPL_PATH', 'templates/main.tpl');

/**
 * Function create login page
 * @return login page
 */
function make_login_page() {
    $holders = array(
        '{CUR_SCRIPT_PATH}' => 'http://'.$_SERVER['HTTP_HOST']
            .$_SERVER['PHP_SELF'],
        '{TITLE}' => 'Login Page',
        '{ROOT_PATH}' => ROOT_PATH,
        '{NICKNAME_VALUE}' => (isset($_POST['nickname']))
            ? $_POST['nickname'] : '',
        '{PASSWORD_VALUE}' => (isset($_POST['password']))
            ? $_POST['password'] : '',
        '{REMEMBER_CHECK}' => (isset($_POST['has_remember']))
            ? 'checked="checked"' : '' 
    );

    $main_tpl = file_get_contents(MAIN_TPL_PATH);
    $login_tpl = file_get_contents(LOGIN_TPL_PATH);
    
    foreach ($holders as $key => $value ) {        
        $main_tpl = str_replace($key, $value, $main_tpl);
        $login_tpl = str_replace($key, $value, $login_tpl);
    }
    
    $main_tpl = str_replace('{BODY}', $login_tpl, $main_tpl);
    return $main_tpl;
}  // make_login_page


function login_user($db_connect = FALSE) {
    if (FALSE === $db_connect) {
        $db_connect = connect_to_database();
	}
	
    $auth = User::getInstance($db_connect);
    $remember = (isset($_POST['has_remember']))? TRUE : FALSE; 
    $auth->login($_POST['nickname'], $_POST['password'], $remember);
}

?>