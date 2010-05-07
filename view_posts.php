<?php

	header('Content-type: text/html; charset=utf-8');
	
	require_once('common.php');
	require_once ("bread_crumps.php");	
	
	$current_user=2;
	
	//Fill the template for each post
	function get_form($tpl, $row, $forum_id, $topic_id, $mes_num, $db_link)
	{
		 $tpl = str_replace('{FORUM_ID}',$forum_id, $tpl);	
		 $tpl = str_replace('{TOPIC_ID}',$topic_id, $tpl);	
		 $tpl = str_replace('{MESSAGE_ID}',$row["pst_id"], $tpl);
		 $tpl = str_replace('{MESSAGE_TEXT}',$row["pst_text"], $tpl);
		 $tpl = str_replace('{NUMBER_OF_MESSAGE}',"#".$mes_num,$tpl);
		 
		 //Get the creator's login using id
		 $uid=$row["pst_sender"];
		 $r = mysql_query("SELECT usr_login 
						   FROM  `bit_forum`.`users` 
						   WHERE  `usr_id` ='$uid' 
						   LIMIT 0 , 30", $db_link);
		 $res =  mysql_fetch_assoc($r);
		 
		 $tpl = str_replace('{POSTER}',$res["usr_login"],$tpl);
		 
		 //Get topic title
		 $r = mysql_query("SELECT tpc_title 
						   FROM  `bit_forum`.`topics` 
						   WHERE  `tpc_id` ='$topic_id' 
						   LIMIT 0 , 30", $db_link);
		 $res =  mysql_fetch_assoc($r);
		 
		 $tpl = str_replace('{TOPIC_HEADER}',$res["tpc_title"],$tpl);
		 
		 $d = date("d.m.Y H:i:s",$row["pst_time"]);
		 $tpl = str_replace('{MESSAGE_DATE}',$d,$tpl);
		 return $tpl;
	} 
	
	function DeletePost($pstid, $current_user, $db_link)
	{
		//Get id of message creator using message id
		$req = mysql_query("SELECT pst_sender 
							FROM  `bit_forum`.`post` 
							WHERE  `pst_id` ='$pstid' 
							LIMIT 0 , 30", $db_link);
		$result = mysql_fetch_assoc($req);
		
		$r = false;
		if ($result["pst_sender"] == $current_user)
		{
			$r = mysql_query("DELETE FROM `post` 
						      WHERE `pst_id` = '$pstid' 
						      LIMIT 1;", $db_link);
		}
		return $r;
	}
	
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages 
	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');//External table of the list of posts
	$tabhead_tpl = file_get_contents('./templates/Topics/posts_table_header.tpl');//header of the table
	$crumps_tpl = file_get_contents('./templates/Topics/bread_crumps.tpl');//Bread crumps template
	$mes_tpl = file_get_contents('./templates/Topics/message_table.tpl');//template for one message
	$form_tpl = file_get_contents('./templates/Topics/form.tpl');//form for message
	
	
	if (isset ($_GET["forum"]))
		$forum_id=$_GET['forum'];
	
	if (isset ($_GET["topic"]))
		$topic_id=$_GET['topic'];
	
	//Get request for deleting topic
	if (isset ($_POST["mes_id"]))
	{
		DeletePost($_POST["mes_id"], $current_user, $db_link);
		header("Location: http://127.0.0.1/bit-forum/view_posts.php?forum=".$forum_id."&topic=".$topic_id);
	}
	
	//Get all messages for this topic
	$r = mysql_query("SELECT* from `post` 
					  WHERE pst_topic='$topic_id'", $db_link);
	$template='';
	$mes_num=1;
	while ($row = mysql_fetch_assoc($r))
	{
		$template = $template.get_form($mes_tpl, $row, $forum_id, $topic_id, $mes_num, $db_link);
		$mes_num++;
	}
	$mes_tpl = $template;
	
	$crumps_tpl = str_replace('{CRUMPS}',GetCrumps($db_link), $crumps_tpl);
	
	$tab_tpl = str_replace('{TABLE_HEADER}', $tabhead_tpl, $tab_tpl);
	$tab_tpl = str_replace('{WHAT_TO_SHOW}', $mes_tpl, $tab_tpl);
	
	$form_tpl = str_replace('{FORUM_ID}', $forum_id, $form_tpl);
	$form_tpl = str_replace('{TOPIC_ID}', $topic_id, $form_tpl);
	
	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $crumps_tpl.$tab_tpl.$crumps_tpl.$form_tpl, $main_tpl);
	
	echo $main_tpl;
?>