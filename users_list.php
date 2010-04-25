<?php

/**
 * File contain function for represent and search users
 * of forum.
 * @author Ilya G. Drobenya
 */

require_once('common.php');
require_once('includes/authorization.php');

/** Count of posts on page */
define('PAGE_SIZE', 30);

define('PAGE_TEMPLATES_FILE', './templates/Admin/users_table.tpl');

/** Mask for test odd number or not */
define('PARITY_MASK', 1);


echo make_page();


function make_page() {
    // Load templates
    $templates = get_templates(PAGE_TEMPLATES_FILE, array(
        "/{(USER_LIST_PAGE)}(.*){EOT}/Us",
        "/{(LINK)}(.*){EOT}/Us",
        "/{(NAVIGATION_BAR)}(.*){EOT}/Us",
        "/{(ODD_ROW)}(.*){EOT}/Us",
        "/{(NOT_ODD_ROW)}(.*){EOT}/Us"
    ));
    
    // create rows for users table
    $page_num = 0;
    if ( isset($_REQUEST['page_num']) ) {
        $page_num = (int)$_REQUEST['page_num'];
    }
    
    $keywords = '';
    if ( isset($_REQUEST['keywords']) ) {
        $keywords = $_REQUEST['keywords'];
    }
    
    $users = get_user_data($keywords, $page_num);
    $table_rows = '';
    foreach ($users as $key => $value) {
        $cur_row = '';
        if ($key&PARITY_MASK) {
            $cur_row = $templates['ODD_ROW'];
        }
        else {
            $cur_row = $templates['NOT_ODD_ROW'];
        }
        
        switch ($value['role']) {
        	case User::REGISTERED_USER:
                $role = 'user';
                break;
        	case User::ADMINISTRATOR:
                $role = 'administrator';
                break;
        	default:
                $role = 'dbase error';
                break; 	
        }
        replace_holders($cur_row, array(
            '{NICKNAME}' => $value['login'],
            '{REG_DATE}' => date('d.m.Y', $value['reg_date']),
            '{USER_ROLE}' => $role,
            '{USER_OPTIONS_PAGE}' => '', 
            '{USER_ID}' => $value['id']
        ));
        
        $table_rows .= $cur_row;
    }
    
    // insert users table to page template
    $table = $templates['USER_LIST_PAGE'];
    replace_holders($table, array(
        '{TABLE_ROWS}' => $table_rows,
        '{KEYWORDS}' => $keywords,
        '{NAVIGATION_TABLE}' => ''
    ));
    
    // insert page template to main page
    $page = file_get_contents(MAIN_TPL_PATH);
    $page = str_replace('{BODY}', $table, $page);
    replace_holders($page, array(
        '{ROOT_PATH}' => ROOT_PATH,
        '{TITLE}' => 'Search User Page'
    ));
    
    return $page;
    
} // show_page


/**
 * Function parse files and return templates
 * as array
 * @param path to file with template
 * @param regexp of template. 
 * Ex. "/{(LINK)}(.*){EOT}/Us" 1st mask - key, 
 * 2nd - value.
 * @return array of templates (template_name 
 * => template)
 */
function get_templates($file_path, $tpl_regexps) {
    // load templates
    $tpl_file = file_get_contents($file_path);
    
    $templates = array();
    foreach ($tpl_regexps as $regexp) {
        preg_match($regexp, $tpl_file, $result);
        $templates[ $result[1] ] = $result[2];
    }
    
    return $templates;
} // search_users


function replace_holders(&$tpl, $holders_map) {
    foreach ($holders_map as $holder => $value) {
        $tpl = str_replace($holder, $value, $tpl);
    }
} // replace_holders


function get_user_data($keyword = '', $page_num = 0) {
    global $db_link;
    
    // fetch users data from database
    $page_num = (string)(int)$page_num;
    $offset = $page_num * PAGE_SIZE;
    $result = mysql_query( 
        "SELECT `usr_id`, `usr_login`, `usr_registr_date`, `usr_role` "
        . "FROM `users` " 
        . "WHERE `usr_login` "
        . "LIKE '%".mysql_escape_string($keyword)."%' "
        . "LIMIT ".$offset.", ".PAGE_SIZE, 
        $db_link);
    
    // create array from received users data
    $users = array();
    while ($row=mysql_fetch_assoc($result)) {
        $users[] = array(
            'id' => $row['usr_id'],
            'login' => $row['usr_login'],
            'reg_date' => $row['usr_registr_date'],
            'role' => $row['usr_role']    
        );
    }
    
    return $users;
}


?>