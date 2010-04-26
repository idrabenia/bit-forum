<?php
require_once ("config.php");
	
$lnk = mysql_connect('localhost', 'root', '1');
mysql_select_db('bit_forum', $lnk);
$current_user=2;

function get_form($tpl, $row, $lnk)
	{
		 $tpl = str_replace('{TOPIC_ID}',$row["tpc_id"], $tpl);
		 $tpl = str_replace('{TOPIC_TITLE}',$row["tpc_title"], $tpl);
		 $uid=$row["tpc_creator"];
		 $r = mysql_query("SELECT usr_login FROM  `bit_forum`.`users` WHERE  `usr_id` ='$uid' LIMIT 0 , 30", $lnk);
		 $res =  mysql_fetch_assoc($r);
		 $tpl = str_replace('{TOPIC_CREATOR}',$res["usr_login"], $tpl);
		 return $tpl;
	} 

$tab_tpl = file_get_contents('./templates/Topics/table.tpl');
$top_tpl = file_get_contents('./templates/Topics/topic_table.tpl');
$form_tpl = file_get_contents('./templates/Topics/form.tpl');
$main_tpl = file_get_contents('./templates/main.tpl');
$tabhead_tpl = file_get_contents('./templates/Topics/topics_table_header.tpl');

if (isset ($_POST["top_id"]))
	{
		$topid=$_POST["top_id"];
		$req = mysql_query("SELECT tpc_creator FROM  `bit_forum`.`topics` WHERE  `tpc_id` ='$topid' LIMIT 0 , 30",$lnk);
		$result = mysql_fetch_assoc($req);
		if ($result["tpc_creator"]==$current_user)
			mysql_query("DELETE FROM `topics` WHERE `tpc_id` = '$topid' LIMIT 1;",$lnk);
		header("Location: http://127.0.0.1/bit-forum/view_topics.php");
	}

$r = mysql_query("SELECT* from `topics`",$lnk);
$template='';
while ($row = mysql_fetch_assoc($r))
	$template = $template.get_form($top_tpl, $row, $lnk);
$head='<table width="100%" cellspacing="1"><tr class="message_header"><td>&nbsp;</td> </tr></table>';

$top_tpl=$head.$template;


$tab_tpl = str_replace('{TABLE_HEADER}',$tabhead_tpl, $tab_tpl);
$tab_tpl = str_replace('{WHAT_TO_SHOW}',$top_tpl, $tab_tpl);
$main_tpl = str_replace('{ROOT_PATH}', '/bit-forum/', $main_tpl);
$main_tpl = str_replace('{BODY}', $tab_tpl.$form_tpl, $main_tpl);
	
echo $main_tpl;

?>