<?php

	header('Content-type: text/html; charset=utf-8');

	require_once ("common.php");
	require_once ("bread_crumps.php");

	$current_user=2;
	
	//Fill the template for each topic
	function get_form($tpl, $row, $db_link)
	{
		if (isset($_GET["forum"]))
			$forum_id=$_GET["forum"];
			
		$tpl = str_replace('{FORUM_ID}',$forum_id, $tpl);
		$tpl = str_replace('{TOPIC_ID}',$row["tpc_id"], $tpl);
		$tpl = str_replace('{TOPIC_TITLE}',$row["tpc_title"], $tpl);
		
		//Get the creator's login using id
		$uid=$row["tpc_creator"];
		$r = mysql_query("SELECT usr_login 
						  FROM  `bit_forum`.`users` 
						  WHERE  `usr_id` ='$uid' 
						  LIMIT 0 , 30", $db_link);
		$res =  mysql_fetch_assoc($r);
		
		$tpl = str_replace('{TOPIC_CREATOR}',$res["usr_login"], $tpl);
		
		return $tpl;
	} 
	
	//Deletes topic with id=topic_id
	function DeleteTopic($topic_id, $current_user, $db_link)
	{
		//Get id of topic creator using topic id
		$req = mysql_query("SELECT tpc_creator 
							FROM  `bit_forum`.`topics` 
							WHERE  `tpc_id` ='$topic_id' 
							LIMIT 0 , 30", $db_link);
		$result = mysql_fetch_assoc($req);
		
		$r=false;
		if ($result["tpc_creator"]==$current_user)
		{
			$r = mysql_query("DELETE FROM `topics` 
						      WHERE `tpc_id` = '$topic_id' 
						      LIMIT 1;",$db_link);
		}
		
		return $r;
	}
	
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages 
	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');//External table of the list of topics
	$tabhead_tpl = file_get_contents('./templates/Topics/topics_table_header.tpl');//header of the table
	$crumps_tpl = file_get_contents('./templates/Topics/bread_crumps.tpl');//Bread crumps template
	$top_tpl = file_get_contents('./templates/Topics/topic_table.tpl');//template for one topic
	$form_tpl = file_get_contents('./templates/Topics/form.tpl');//form for message

	if (isset ($_GET["forum"]))
	    $forum_id=$_GET['forum'];

	//Get request for deleting topic
	if (isset ($_POST["top_id"]))
	{
		DeleteTopic($_POST["top_id"], $current_user, $db_link);
		header("Location: http://127.0.0.1/bit-forum/view_topics.php?forum=".$forum_id);
	}

	//Get all topics for this forum
	$r = mysql_query("SELECT* from `topics` 
					  WHERE tpc_forum='$forum_id'",$db_link);
	$template='';
	while ($row = mysql_fetch_assoc($r))
		$template = $template.get_form($top_tpl, $row, $db_link);

	//Empty row in table. Simply for design.	
	$head='<table width="100%" cellspacing="1"><tr class="message_header"><td>&nbsp;</td> </tr></table>';

	$top_tpl = $head.$template;

	$crumps_tpl = str_replace('{CRUMPS}', GetCrumps($db_link), $crumps_tpl);

	$tab_tpl = str_replace('{TABLE_HEADER}', $tabhead_tpl, $tab_tpl);
	$tab_tpl = str_replace('{WHAT_TO_SHOW}', $top_tpl, $tab_tpl);

	$form_tpl = str_replace('{FORUM_ID}', $forum_id, $form_tpl);
	$form_tpl = str_replace('{TOPIC_ID}',0, $form_tpl);

	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $crumps_tpl.$tab_tpl.$crumps_tpl.$form_tpl, $main_tpl);

	echo $main_tpl;
?>