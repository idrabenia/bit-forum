<?php
	require_once ("config.php");
		
	$lnk = mysql_connect('localhost', 'root', '1');
	mysql_select_db('bit_forum', $lnk);
	$current_user=2;

	function get_form($tpl, $row, $lnk)
	{
		 $tpl = str_replace('{FORUM_ID}',$row["frm_id"], $tpl);
		 $tpl = str_replace('{FORUM_TITLE}',$row["frm_title"], $tpl);
		 $uid=$row["frm_moderator"];
		 $r = mysql_query("SELECT usr_login FROM  `bit_forum`.`users` WHERE  `usr_id` ='$uid' LIMIT 0 , 30", $lnk);
		 $res =  mysql_fetch_assoc($r);
		 $tpl = str_replace('{FORUM_MODERATOR}',$res["usr_login"], $tpl);
		 return $tpl;
	} 

	$tab_tpl = file_get_contents('./templates/Topics/table.tpl');
	$forum_tpl = file_get_contents('./templates/Topics/forum_table.tpl');
	$form_tpl = file_get_contents('./templates/Topics/form.tpl');
	$main_tpl = file_get_contents('./templates/main.tpl');
	$tabhead_tpl = file_get_contents('./templates/Topics/forums_table_header.tpl');
	
	
	$r = mysql_query("SELECT* from `forums`",$lnk);
	$template='';
	while ($row = mysql_fetch_assoc($r))
		$template = $template.get_form($forum_tpl, $row, $lnk);
	$head='<table width="100%" cellspacing="1"><tr class="message_header"><td>&nbsp;</td> </tr></table>';
    $forum_tpl=$head.$template;
	
	$tab_tpl = str_replace('{TABLE_HEADER}',$tabhead_tpl, $tab_tpl);
	$tab_tpl = str_replace('{WHAT_TO_SHOW}',$forum_tpl, $tab_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', '/bit-forum/', $main_tpl);
	$main_tpl = str_replace('{BODY}', $tab_tpl.$form_tpl, $main_tpl);
	echo $main_tpl;
?>