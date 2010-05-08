<?php
	
	header('content-type: text/html; charset=utf8');
	
	require_once ("common.php");
	require_once ("bread_crumps.php");	

	$current_user=2;
	
	//Fill the template for each forum
	function get_form($tpl, $row, $show_del, $db_link)
	{
		 $tpl = str_replace('{FORUM_ID}', $row["frm_id"], $tpl);
		 $tpl = str_replace('{FORUM_TITLE}', $row["frm_title"], $tpl);
		 $tpl = str_replace('{FORUM_DESCRIPTION}',$row["frm_description"], $tpl);
		 
		 //Get moderator's  login using id
		 $uid = $row["frm_moderator"];
		 $r = mysql_query("SELECT usr_login FROM  `bit_forum`.`users` WHERE  `usr_id` ='$uid' LIMIT 0 , 30", $db_link);
		 $res =  mysql_fetch_assoc($r);
		 
		 $tpl = str_replace('{FORUM_MODERATOR}', $res["usr_login"], $tpl);
		 
		 if ($show_del)
		{
			$del_tpl = file_get_contents('./templates/Topics/delete_form.tpl');
			
			$del_tpl = str_replace('{ACTION}', "view_forums.php", $del_tpl);
			$del_tpl = str_replace('{INST_ID}', $row["frm_id"], $del_tpl);
			
			$tpl = str_replace('{DELETE_FORM}', $del_tpl, $tpl);
		}
		else
			$tpl = str_replace('{DELETE_FORM}','', $tpl);
		 
		 return $tpl;
	} 
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages 
	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');//External table of the list of forums
	$crumps_tpl = file_get_contents('./templates/Topics/bread_crumps.tpl');//Bread crumps template
	$tabhead_tpl = file_get_contents('./templates/Topics/forums_table_header.tpl');//Header of the table
	$forum_tpl = file_get_contents('./templates/Topics/forum_table.tpl');//table for one forum information
	//$form_tpl = file_get_contents('./templates/Topics/form.tpl');
	
	//Find out if we should show delete button
	$show_del = false;
	$r = mysql_query("SELECT usr_role 
					  FROM `users` 
					  WHERE usr_id='$current_user'", $db_link);
	$row = mysql_fetch_assoc($r);
	if ($row["usr_role"]==3)
		$show_del=true;
	
	if (isset ($_POST["inst_id"]))
	{
		$forum_id = $_POST['inst_id'];
		mysql_query("DELETE FROM `forums` 
					 WHERE `frm_id` = '$forum_id' 
				     LIMIT 1;",$db_link);
		header("Location: http://127.0.0.1/bit-forum/view_forums.php");
	}
	
	$r = mysql_query("SELECT * from `forums`", $db_link);
	
	$template = '';
	while ($row = mysql_fetch_assoc($r))
		$template = $template.get_form($forum_tpl, $row,$show_del, $db_link);
		
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