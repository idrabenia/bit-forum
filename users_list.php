<?php

/**
 * File contain function for represent and search users
 * of forum.
 * @author Ilya G. Drobenya
 */

require_once('common.php');
require_once('includes/authorization.php');
require_once('includes/templates_engine.php');

/** Count of posts on page */
define('PAGE_SIZE', 10);

define('PAGE_TEMPLATES_FILE', './templates/Admin/users_table.tpl');

/** Mask for test odd number or not */
define('PARITY_MASK', 1);

//echo get_pages_count('');
echo make_page();
//echo "hello";


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
    $keywords = '';
    if ( isset($_REQUEST['keywords']) ) {
        $keywords = $_REQUEST['keywords'];
    }
    
    $page_num = 0;
    if ( isset($_REQUEST['page_num']) ) {
        $page_num = (int)$_REQUEST['page_num'];
        
        // check page number interval
        if ((get_pages_count($keywords)<=$page_num)
            ||(0>$page_num)) {
            $page_num = 0;
        }
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
    
    // create navigation bar
    $bar = $templates['NAVIGATION_BAR'];
    $link_tpl = $templates['LINK'];
    
    // create link to previous page
    $prev_link = '';
    if (0!==$page_num) {
        $prev_link = $link_tpl;
        replace_holders($prev_link, array(
            '{PAGE_DESC}' => 'Previuos',
            '{PAGE_LINK}' => $_SERVER['PHP_SELF']
                ."?page_num=".($page_num - 1)
                ."&keywords=".rawurlencode($keywords)
        ));
    }
    
    // create link to start page
    $start_link = '';
    if (1<=$page_num) {
        $start_link = $link_tpl;
        replace_holders( $start_link, array(
            '{PAGE_DESC}' => 'Start',
            '{PAGE_LINK}' => $_SERVER['PHP_SELF']
                . "?page_num=0"
                . "&keywords=".rawurlencode($keywords)
        ) );
    }
    
    // create link to next page
    $next_link = '';
    if ($page_num<get_pages_count($keywords)-1) {
        $next_link = $link_tpl;
        replace_holders($next_link, array(
            '{PAGE_DESC}' => 'Next',
            '{PAGE_LINK}' => $_SERVER['PHP_SELF']
                . "?page_num=".($page_num + 1)
                . "&keywords=".rawurlencode($keywords)
        ));
    }
    
    replace_holders($bar, array(
        '{PREV_PAGE}' => $prev_link,
        '{START_PAGE}' => $start_link,
        '{NEXT_PAGE}' => $next_link
    ));
    
    // insert users table to page template
    $table = $templates['USER_LIST_PAGE'];
    replace_holders($table, array(
        '{TABLE_ROWS}' => $table_rows,
        '{KEYWORDS}' => $keywords,
        '{NAVIGATION_TABLE}' => $bar, 
        '{CUR_PAGE_URL}' => $_SERVER['PHP_SELF']
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
} // get_user_data


/**
 * Function returns count of pages that need to show
 * all results of search
 * @param $keywords keyswords for user search login
 * @return (int) count of pages that need to show 
 * search results
 */
function get_pages_count($keywords = '') {
    global $db_link;
    static $count_cash = FALSE;
    
    if ($count_cash!==FALSE) {
        return $count_cash;
    }
    
    $result = mysql_query(
        "SELECT COUNT(*) FROM `users` WHERE `usr_login` "
        . "LIKE '%".mysql_escape_string($keywords)."%'", 
        $db_link);
        
    $row = mysql_fetch_row($result);
    
    $rows_count = (int)$row[0]; 
    $pages_count = ceil($rows_count / PAGE_SIZE);
    
    $counts = $pages_count;
    return $pages_count;
} // get_pages_count


?>