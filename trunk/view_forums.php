<?php
	
	header('content-type: text/html; charset=utf8');
	
	require_once ("common.php");
	require_once ("bread_crumps.php");	

	$current_user=1;
	
	//Fill the template for each forum
	function get_form($tpl, $row, $db_link)
	{
		 $tpl = str_replace('{FORUM_ID}', $row["frm_id"], $tpl);
		 $tpl = str_replace('{FORUM_TITLE}', $row["frm_title"], $tpl);
		 $tpl = str_replace('{FORUM_DESCRIPTION}',$row["frm_description"], $tpl);
		 
		 //Get moderator's  login using id
		 $uid = $row["frm_moderator"];
		 $r = mysql_query("SELECT usr_login FROM  `bit_forum`.`users` WHERE  `usr_id` ='$uid' LIMIT 0 , 30", $db_link);
		 $res =  mysql_fetch_assoc($r);
		 
		 $tpl = str_replace('{FORUM_MODERATOR}', $res["usr_login"], $tpl);
		 
		 return $tpl;
	} 
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages 
	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');//External table of the list of forums
	$crumps_tpl = file_get_contents('./templates/Topics/bread_crumps.tpl');//Bread crumps template
	$tabhead_tpl = file_get_contents('./templates/Topics/forums_table_header.tpl');//Header of the table
	$forum_tpl = file_get_contents('./templates/Topics/forum_table.tpl');//table for one forum information
	//$form_tpl = file_get_contents('./templates/Topics/form.tpl');
	
	
	$r = mysql_query("SELECT * from `forums`", $db_link);
	
	$template = '';
	while ($row = mysql_fetch_assoc($r))
		$template = $template.get_form($forum_tpl, $row, $db_link);
		
	//Empty row in table. Simply for design.	
	$head = '<table width="100%" cellspacing="1"><tr class="message_header"><td>&nbsp;</td> </tr></table>';
    
	$forum_tpl = $head.$template;
	
	$tab_tpl = str_replace('{TABLE_HEADER}',$tabhead_tpl, $tab_tpl);
	$tab_tpl = str_replace('{WHAT_TO_SHOW}',$forum_tpl, $tab_tpl);
	
	$crumps_tpl = str_replace('{CRUMPS}', GetCrumps($db_link), $crumps_tpl);
	
	$main_tpl = str_replace('{TITLE}',"БИТ-форум - Список форумов",$main_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $crumps_tpl.$tab_tpl.$crumps_tpl, $main_tpl);
	
	echo $main_tpl;
?>