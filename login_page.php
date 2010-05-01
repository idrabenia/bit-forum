<?php

/**
 * File content functions for represent
 * login page.
 */  

require_once('common.php');
require_once('includes/authorization.php');
require_once('includes/templates_engine.php');

define('LOGIN_TPL_PATH', 'templates/login.tpl');
define('REDIRECT_TPL_PATH', 'templates/redirect.tpl');


$usr = User::getInstance();

// Processing requests
// GET: act=logout, [ url=some.url ]
// request for logout user
if ( isset($_GET['act']) && ($_GET['act'] === 'logout') ) {
    save_url( $_GET['url'] );
    logout_user();
    
    header("Location: " . get_redirect_url());
}
// POST: nickname=some_name, password=some_passw
// request for authenticate user
else if (isset($_POST['nickname']) && isset($_POST['password'])) {
    if (!has_valid_captcha($_POST['captcha'])) {
        echo make_login_page();
        exit();
    }
    
    if ($usr->isGuest()) {
        login_user();   
    }
    
    if ($usr->isGuest()) {
        echo make_login_page('Пароль или логин не верные');
    } else {
        echo redirect_page();
    }
}
// GET: [ url=some.url ]
// request for get page for authentication
else {
    save_url($_GET['url']);
    
    if ($usr->isGuest()) {
        echo make_login_page();
    } else {
        echo redirect_page();
    }
} 


/**
 * Function create login page
 * @return login page
 */
function make_login_page($error_msg = '') {
    
    $holders = array(
        '{ERROR_MESSAGE}' => $error_msg,
        '{CUR_SCRIPT_PATH}' => $_SERVER['PHP_SELF'],
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
    global $db_link;

    $db_connect = $db_link;
    $auth = User::getInstance($db_connect);
    $remember = (isset($_POST['has_remember']))? TRUE : FALSE; 
    $auth->login($_POST['nickname'], $_POST['password'], $remember);
}


/** Function for logout user */
function logout_user() {
    $auth = User::getInstance();
    $auth->logout();
}


/** 
 * Function save url that used for redirect after 
 * login complete. Url will be validated.
 */
function save_url(&$url) {
    @session_start();
    
    if ( isset($url) ) {
        $_SESSION['redirect_url'] = $url;       	
    } else {
        $_SESSION['redirect_url'] = MAIN_PAGE;
    } 
}


/** Function return url for redirect after login complete */
function get_redirect_url() {
    @session_start();
    
    if ( isset($_SESSION['redirect_url']) ) {
        return $_SESSION['redirect_url'];       
    }
    
    return MAIN_PAGE;
}


function has_valid_captcha(&$text) {
    @session_start();
    if (!isset($_SESSION['captcha'])) {
        return FALSE;        
    }
    
    if (isset($text) && ($_SESSION['captcha'] === $text)) {
        return TRUE;
    }
    
    return FALSE;
}


/** 
 * Function for redirect user to other page
 * after successful authorization  
 * @return page for redirection
 */
function redirect_page() {    
    $usr = User::getInstance();
    if (($usr->isGuest())) {
        if (DEBUG) {
            die('function redirect_user in login_page.php '
                . 'called for unregistered user');
        } else {
            die('Error 404: File Not Found');
        }
    }
    
    $tpl = file_get_contents(REDIRECT_TPL_PATH);
    replace_holders($tpl, array(
        '{NICKNAME}' => $usr->getUserNickname(),
        '{REDIRECT_URL}' => get_redirect_url()
    ));
    
    return $tpl;
} // redirect_user


?>