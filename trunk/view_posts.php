<?php

	header('Content-type: text/html; charset=utf-8');
	require_once ("config.php");
	error_reporting(1);
	//display_errors=On;
	
	$lnk = mysql_connect('localhost', 'root', '1');
	mysql_select_db('bit_forum', $lnk);
	$current_user=2;
	function get_form($tpl, $row, $mes_num, $lnk)
	{
		 $tpl = str_replace('{MESSAGE_ID}',$row["pst_id"], $tpl);
		 $tpl = str_replace('{MESSAGE_TEXT}',$row["pst_text"], $tpl);
		 $tpl = str_replace('{NUMBER_OF_MESSAGE}',"#".$mes_num,$tpl);
		 $uid=$row["pst_sender"];
		 $r = mysql_query("SELECT usr_login FROM  `bit_forum`.`users` WHERE  `usr_id` ='$uid' LIMIT 0 , 30", $lnk);
		 $res =  mysql_fetch_assoc($r);
		 $tpl = str_replace('{POSTER}',$res["usr_login"],$tpl);
		 $topic = $row["pst_topic"];
		 $r = mysql_query("SELECT tpc_title FROM  `bit_forum`.`topics` WHERE  `tpc_id` ='$topic' LIMIT 0 , 30", $lnk);
		 $res =  mysql_fetch_assoc($r);
		 $tpl = str_replace('{TOPIC_HEADER}',$res["tpc_title"],$tpl);
		 $d = date("d.m.Y H:i:s",$row["pst_time"]);
		 $tpl = str_replace('{MESSAGE_DATE}',$d,$tpl);
		 return $tpl;
	} 
	
	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');
	$mes_tpl = file_get_contents('./templates/Topics/message_table.tpl');
	$form_tpl = file_get_contents('./templates/Topics/form.tpl');
	$main_tpl = file_get_contents('./templates/main.tpl');
	$tabhead_tpl = file_get_contents('./templates/Topics/posts_table_header.tpl');
	
	
	if (isset ($_POST["mes_id"]))
	{
		$pstid=$_POST["mes_id"];
		$req = mysql_query("SELECT pst_sender FROM  `bit_forum`.`post` WHERE  `pst_id` ='$pstid' LIMIT 0 , 30",$lnk);
		$result = mysql_fetch_assoc($req);
		if ($result["pst_sender"]==$current_user)
			mysql_query("DELETE FROM `post` WHERE `pst_id` = '$pstid' LIMIT 1;",$lnk);
		header("Location: http://127.0.0.1/bit-forum/view_posts.php");
	}
	$r = mysql_query("SELECT* from `post`",$lnk);
	$template='';
	$mes_num=1;
	while ($row = mysql_fetch_assoc($r))
	{
		$template = $template.get_form($mes_tpl, $row,$mes_num, $lnk);
		$mes_num++;
	}
	$mes_tpl=$template;
	
	$tab_tpl = str_replace('{TABLE_HEADER}',$tabhead_tpl, $tab_tpl);
	$tab_tpl = str_replace('{WHAT_TO_SHOW}',$mes_tpl, $tab_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', '/bit-forum/', $main_tpl);
	$main_tpl = str_replace('{BODY}', $tab_tpl.$form_tpl, $main_tpl);
	
	 echo $main_tpl;
?>