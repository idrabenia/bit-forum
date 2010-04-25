<?php

	$lnk = mysql_connect('127.0.0.1', 'root', '1') or die ('could not connect');
	mysql_select_db('bit_forum', $lnk) or die ('no connection');
	
	function get_form($tpl, $row)
	{
		$tpl = str_replace('{IN_FIRST_NAME}','', $tpl);
		$tpl = str_replace('{IN_LAST_NAME}','', $tpl);
		$tpl = str_replace('{IN_CURRPASSWORD}','', $tpl);
		$tpl = str_replace('{IN_NEWPASSWORD}','', $tpl);
		$tpl = str_replace('{IN_CONFPASSWORD}','', $tpl);
		$tpl = str_replace('{IN_EMAIL}',$row["usr_email"], $tpl);
		$tpl = str_replace('{IN_MOBILE}','', $tpl);
		 
		$tpl = str_replace('{IN_ICQ}','', $tpl);
		$tpl = str_replace('{IN_URL}','', $tpl);
		$tpl = str_replace('{IN_COUNTRY}','', $tpl);
		$tpl = str_replace('{IN_INTERESTS}','', $tpl);
		$tpl = str_replace('{IN_ABOUT}','', $tpl);
		return $tpl;
	} 
	
	
	
	
	$user_page = file_get_contents('user_page.tpl');
	
	$id = 44;
	$sql = "SELECT * FROM users WHERE usr_id = $id";
	$r = mysql_query($sql, $lnk);
	//echo '<br>'.$sql.'<br>';
	//echo $r;
	$row = mysql_fetch_assoc($r);
	//echo $row["usr_email"];
	$out_tpl = '';
	$out_tpl = $out_tpl.get_form($user_page, $row);
	echo $out_tpl;
	
	
	

?>