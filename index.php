<?php

require_once('common.php');
require_once('includes/message_parser.php');
require_once('includes/authorization.php');
require_once('login_page.php');

echo '<a href="view_topics.php">View topics</a>'.'<br/>';
echo '<a href="view_posts.php">View posts</a>'.'<br/>';
echo '<a href="view_forums.php">View forums</a>'.'<br/>'; 

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
