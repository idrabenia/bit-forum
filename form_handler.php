<?php

header('Content-type: text/html; charset=utf8');
require_once ("common.php");
require_once ("includes/authorization.php");

$topic_id=0;
$message_id=0;
if (isset ($_GET["forum"]))
	$forum_id=$_GET["forum"];
if (isset ($_GET["topic"]))
	$topic_id=$_GET["topic"];
if (isset ($_GET["message"]))
   $message_id=$_GET["message"];

$auth = User::getInstance();	

if ($auth->isGuest())
{
	if ($topic_id==0)
		$url = urlencode("view_topics.php?forum=".$forum_id);
	else
		$url = urlencode("view_posts.php?forum=".$forum_id."&topic=".$topic_id);
	echo "Вы не авторизованы и не можете оставлять сообщений!<br/> 
		  Чтобы иметь такую возможность вы должны <a href='login_page.php?url=".$url."'>авторизоваться</a>";
	die();
}
else
	$current_user = $auth->getUserId();
	
if ($topic_id ==0)
{
	$ttl='';
	if ((isset($_POST["textfield"]))&&($_POST["textfield"]!==''))
	{
		
			$ttl=$_POST["textfield"];
			
			mysql_query("INSERT INTO  `bit_forum`.`topics` (
									  `tpc_id` ,
									  `tpc_creator` ,
									  `tpc_forum` ,
									  `tpc_title`)
									   VALUES (
									   NULL ,  '$current_user',  '$forum_id',  '$ttl')",$db_link);
									   
	}
	else
	{
		echo "При создании новой темы нужно указывать ЗАГОЛОВОК!<br/> 
			 <a href='view_topics.php?forum=".$forum_id."'>Вернуться назад</a>";
		die();
	}
}

$msg='';
if ((isset($_POST["message_area"]))&&($_POST["message_area"]!==''))
{
	if ($topic_id==0)
	{
		$r=mysql_query("SELECT MAX( tpc_id ) FROM `topics` ");
		$res= mysql_fetch_assoc($r);
		$topic_id=$res["MAX( tpc_id )"];
	}
	if ($message_id==0)
	{
		$msg=$_POST["message_area"];
		$t=time();
		mysql_query("INSERT INTO  `bit_forum`.`post` (
								  `pst_id` ,
								  `pst_sender` ,
								  `pst_topic` ,
								  `pst_time` ,
								  `pst_text`)
								   VALUES (
								   NULL ,  '$current_user',  '$topic_id',  '$t',  '$msg')",$db_link);
	}
	else
	{
		$msg=$_POST["message_area"];
		echo $message_id."<br/>";
		echo $msg;
		mysql_query("UPDATE post 
					 SET pst_text='$msg'
					 WHERE pst_id='$message_id'", $db_link);
	}
}
else
{
	if ($topic_id==0)
		$url = "view_topics.php?forum=".$forum_id;
	else
		$url = "view_posts.php?forum=".$forum_id."&topic=".$topic_id;
	echo "Нельзя отправлять ПУСТОЕ сообщение!<br/> 
		 <a href='".$url."'>Вернуться назад</a>";
	die();
}
if ($message_id==0)
{
	$r=mysql_query("SELECT MAX( pst_id ) FROM `post` ");
	$res= mysql_fetch_assoc($r);
	$message_id=$res["MAX( pst_id )"];
}
header("Location: ".$ROOT_PATH."view_posts.php?forum=".$forum_id."&topic=".$topic_id."#".$message_id);
?>