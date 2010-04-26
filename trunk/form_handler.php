<?php
$lnk = mysql_connect('localhost', 'root', '1');
mysql_select_db('bit_forum', $lnk);
$current_user=2;


$ttl='';
if ((isset($_POST["title"]))&&($_POST["title"]!==''))
{
	$ttl=$_POST["title"];
	echo $ttl;
	mysql_query("INSERT INTO  `bit_forum`.`topics` (
							  `tpc_id` ,
							  `tpc_creator` ,
							  `tpc_forum` ,
							  `tpc_title`)
							   VALUES (
							   NULL ,  '$current_user',  '2',  '$ttl')",$lnk);
	header("Location: http://127.0.0.1/bit-forum/view_topics.php");
}

$msg='';
if ((isset($_POST["textarea"]))&&($_POST["textarea"]!==''))
{
	$msg=$_POST["textarea"];
	$t=time();
	mysql_query("INSERT INTO  `bit_forum`.`post` (
							  `pst_id` ,
							  `pst_sender` ,
							  `pst_topic` ,
							  `pst_time` ,
							  `pst_text`)
							   VALUES (
							   NULL ,  '$current_user',  '1',  '$t',  '$msg')",$lnk);
	header("Location: http://127.0.0.1/bit-forum/view_posts.php");
}
?>