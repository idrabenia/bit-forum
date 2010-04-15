<?php

require_once('common.php');
require_once('includes/message_parser.php');
require_once('includes/admin_panel.php');
require_once('includes/authorization.php');
require_once('includes/login_page.php');


$auth = User::getInstance();
$action_type = ( isset($_REQUEST['action']) )? $_REQUEST['action'] 
    : '';
    
switch ($action_type) {
    case 'login': 
        if (User::GUEST === $auth->getUserRole()) {
        	echo "login user";
            login_user();
        }
        if (User::GUEST === $auth->getUserRole()) {
        	echo "make_login_page";
            echo make_login_page();
        }
        else {
            header("Location: http://".$_SERVER['HTTP_HOST']
                .$_SERVER['PHP_SELF']."?action=admin_panel");
        }
    break;
    
    case 'admin_panel':
        if (User::ADMINISTRATOR === $auth->getUserRole()) {
        	modify_config();
            echo make_admin_panel();
        } 
        else {
            header('Location: http://'.$_SERVER['HTTP_HOST']
                .$_SERVER['PHP_SELF'].'?action=login');
        }
    break;
    
    default:
    	// Show main page
    	header("Location: http://".$_SERVER['HTTP_HOST']
    	   .$_SERVER['PHP_SELF']."?action=admin_panel");
} 

?>
