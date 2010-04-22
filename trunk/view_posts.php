<?php

	header('Content-type: text/html; charset=utf-8');
	require_once ("config.php");
	
	$lnk = mysql_connect('localhost', 'root', '1');
	mysql_select_db('forumdb', $lnk);
	
	function get_form($tpl, $row, $mes_num, $lnk)
	{
		 $tpl = str_replace('{MESSAGE_ID}',$row["pst_id"], $tpl);
		 $tpl = str_replace('{MESSAGE_TEXT}',$row["pst_text"], $tpl);
		 $tpl = str_replace('{NUMBER_OF_MESSAGE}',"#".$mes_num,$tpl);
		 $uid=$row["pst_sender"];
		 $r = mysql_query("SELECT u_name FROM  `forumdb`.`users` WHERE  `u_id` ='$uid' LIMIT 0 , 30", $lnk);
		 $res =  mysql_fetch_assoc($r);
		 $tpl = str_replace('{POSTER}',$res["u_name"],$tpl);
		 $topic = $row["pst_topic"];
		 $r = mysql_query("SELECT tpc_title FROM  `forumdb`.`topics` WHERE  `tpc_id` ='$topic' LIMIT 0 , 30", $lnk);
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
	
	
	
	
	$msg='';
	if (isset($_POST["textarea"]))
	{
		$msg=$_POST["textarea"];
		$t=time();
		mysql_query("INSERT INTO  `forumdb`.`post` (
								  `pst_id` ,
								  `pst_sender` ,
								  `pst_topic` ,
								  `pst_time` ,
								  `pst_text`)
								   VALUES (
								   NULL ,  '2',  '1',  '$t',  '$msg')",$lnk);
		header("Location: http://127.0.0.1/bit-forum");
	}
	if (isset ($_POST["mes_id"]))
	{
		$pstid=$_POST["mes_id"];
		$r = mysql_query("DELETE FROM `post` WHERE `pst_id` = '$pstid' LIMIT 1;",$lnk);
		header("Location: http://127.0.0.1/bit-forum");
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
	
	
	$tab_tpl = str_replace('{MESSAGE_TABLE}',$mes_tpl, $tab_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', '../bit-forum/', $main_tpl);
	$main_tpl = str_replace('{BODY}', $tab_tpl.$form_tpl, $main_tpl);
	
	//echo 'Error';
	 echo $main_tpl;
?>