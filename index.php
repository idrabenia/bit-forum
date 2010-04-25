<?php

require_once('common.php');
require_once('includes/message_parser.php');
require_once('includes/authorization.php');
require_once('login_page.php');


//$auth = User::getInstance();
//$action_type = ( isset($_REQUEST['action']) )? $_REQUEST['action'] 
//    : '';
//    
//switch ($action_type) {
//    case 'login': 
//        if ( $auth->isGuest() ) {
//            login_user();
//        }
//        if ( $auth->isGuest() ) {
//            echo make_login_page();
//        }
//        else {
//            header("Location: http://".$_SERVER['HTTP_HOST']
//                .$_SERVER['PHP_SELF']."?action=admin_panel");
//        }
//    break;
//    
//    case 'admin_panel':
//        if ( $auth->isAdmin() ) {
//        	modify_config();
//            echo make_admin_panel();
//        } 
//        else {
//            header('Location: http://'.$_SERVER['HTTP_HOST']
//                .$_SERVER['PHP_SELF'].'?action=login');
//        }
//    break;
//    
//    default:
//    	// Show main page
//    	header("Location: http://".$_SERVER['HTTP_HOST']
//    	   .$_SERVER['PHP_SELF']."?action=admin_panel");
//} 

echo <<<EOL
    Hello, 
    World
    !
    !
    !
EOL;

exit();

if (User::getInstance()->isAdmin()) {
    header("Location: http://".$_SERVER['HTTP_HOST']
            ."/admin_panel.php");
}
else {
    header("Location: http://".$_SERVER['HTTP_HOST']
            ."/login_page.php");
}

?>
