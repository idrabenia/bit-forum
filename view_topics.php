<?php

	header('Content-type: text/html; charset=utf-8');

	require_once ("common.php");
	require_once ("bread_crumps.php");
	require_once ('includes/message_parser.php');
	require_once ("includes/authorization.php");
	
	//Fill the template for each topic
	function get_form($tpl, $row, $auth, $db_link)
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
		
		if ($auth->isAdmin())
		{
			$del_tpl = file_get_contents('./templates/Topics/delete_form.tpl');
			
			$del_tpl = str_replace('{ACTION1}', "view_topics.php?forum=".$forum_id, $del_tpl);
			$del_tpl = str_replace('{INST_ID}', $row["tpc_id"], $del_tpl);
			
			$tpl = str_replace('{DELETE_FORM}', $del_tpl, $tpl);
		}
		else
			$tpl = str_replace('{DELETE_FORM}','', $tpl);
		
		return $tpl;
	} 
	
	//Deletes topic with id=topic_id
	function DeleteTopic($topic_id, $auth, $db_link)
	{
		//Get id of topic creator using topic id
		$req = mysql_query("SELECT tpc_creator 
							FROM  `bit_forum`.`topics` 
							WHERE  `tpc_id` ='$topic_id' 
							LIMIT 0 , 30", $db_link);
		$result = mysql_fetch_assoc($req);
		
		$r=false;
		if ($result["tpc_creator"]==$auth->getUserId())
		{
			$r = mysql_query("DELETE FROM `topics` 
						      WHERE `tpc_id` = '$topic_id' 
						      LIMIT 1;",$db_link);
		}
		
		return $r;
	}
	
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages 
	$log_tpl = file_get_contents('./templates/Topics/log_in_out.tpl');//Line with information about user
	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');//External table of the list of topics
	$tabhead_tpl = file_get_contents('./templates/Topics/topics_table_header.tpl');//header of the table
	$crumps_tpl = file_get_contents('./templates/Topics/bread_crumps.tpl');//Bread crumps template
	$top_tpl = file_get_contents('./templates/Topics/topic_table.tpl');//template for one topic
	$form_tpl = file_get_contents('./templates/Topics/form.tpl');//form for message

	$auth = User::getInstance();
	
	if (isset ($_GET["forum"]))
	    $forum_id=$_GET['forum'];

	//Get request for deleting topic
	if (isset ($_POST["inst_id"]))
	{
		DeleteTopic($_POST["inst_id"], $auth, $db_link);
		header("Location: ".$ROOT_PATH."view_topics.php?forum=".$forum_id);
	}
	
	//Get all topics for this forum
	$r = mysql_query("SELECT* from `topics` 
					  WHERE tpc_forum='$forum_id' 
					  ORDER BY tpc_id DESC",$db_link);
	$template='';
	while ($row = mysql_fetch_assoc($r))
		$template = $template.get_form($top_tpl, $row, $auth, $db_link);

	//Empty row in table. Simply for design.	
	$head='<table width="100%" cellspacing="1"><tr class="message_header"><td>&nbsp;</td> </tr></table>';

	$top_tpl = $head.$template;

	if ($auth->isGuest())
	{
		$url = urlencode("view_topics.php?forum=".$forum_id);
		$log_tpl =  str_replace('{CURR_STATE1}',"<a href = 'login_page.php?url=".$url."'>Войти </a>", $log_tpl);
		$log_tpl =  str_replace('{CURR_STATE2}',"<a href = ''> Зарегистрироваться</a>", $log_tpl);
	}
	else
	{
		$url = urlencode("view_topics.php?forum=".$forum_id);
		$log_tpl =  str_replace('{CURR_STATE1}',"Текущий пользователь -  ".$auth->getUserNickname(), $log_tpl);
		$log_tpl =  str_replace('{CURR_STATE2}',"<a href = 'login_page.php?act=logout&url=".$url."'>Выйти</a>", $log_tpl);

	}
	
	$crumps_tpl = str_replace('{CRUMPS}', GetCrumps($db_link), $crumps_tpl);

	$tab_tpl = str_replace('{TABLE_HEADER}', $tabhead_tpl, $tab_tpl);
	$tab_tpl = str_replace('{WHAT_TO_SHOW}', $top_tpl, $tab_tpl);

	$form_tpl = str_replace('{FORUM_ID}', $forum_id, $form_tpl);
	$form_tpl = str_replace('{TOPIC_ID}',0, $form_tpl);
	$form_tpl = str_replace('{ROOTPATH}',ROOT_PATH, $form_tpl);
	$form_tpl = str_replace('{TITLE}',"Новая тема", $form_tpl);
	$form_tpl = str_replace('{TITLE_VAL}',"", $form_tpl);
	$form_tpl = str_replace('{TEXT_VAL}',"", $form_tpl);
	$form_tpl = str_replace('{MESS_ID}',0, $form_tpl);
	
	$r = mysql_query("SELECT frm_title from `forums` 
					  WHERE frm_id='$forum_id'", $db_link);
	$row = mysql_fetch_assoc($r);
	
	$main_tpl = str_replace('{TITLE}', "БИТ-форум - ".$row["frm_title"], $main_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $log_tpl.$crumps_tpl.$tab_tpl.$crumps_tpl.$form_tpl, $main_tpl);

	echo $main_tpl;
?>