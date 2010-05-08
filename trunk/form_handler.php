<?php

header('Content-type: text/html; charset=utf8');
require_once ("common.php");

$lnk = $db_link;
$current_user=7;


$topic_id=0;
if (isset ($_GET["forum"]))
	$forum_id=$_GET["forum"];
if (isset ($_GET["topic"]))
	$topic_id=$_GET["topic"];

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
									   NULL ,  '$current_user',  '$forum_id',  '$ttl')",$lnk);
									   
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
	$msg=$_POST["message_area"];
	$t=time();
	mysql_query("INSERT INTO  `bit_forum`.`post` (
							  `pst_id` ,
							  `pst_sender` ,
							  `pst_topic` ,
							  `pst_time` ,
							  `pst_text`)
							   VALUES (
							   NULL ,  '$current_user',  '$topic_id',  '$t',  '$msg')",$lnk);
	
}

header("Location: http://127.0.0.1/bit-forum/view_posts.php?forum=".$forum_id."&topic=".$topic_id);
?>