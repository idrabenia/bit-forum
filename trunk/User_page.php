<?php
	header('Content-type: text/html; charset=utf-8');

	require_once ("common.php");
	
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages
	$user_page_tpl = file_get_contents('./templates/User/user_page.tpl');//Registration form
	

	$lnk = mysql_connect('127.0.0.1', 'root', '1') or die ('could not connect');
	mysql_select_db('bit_forum', $lnk) or die ('no connection');
	
	function get_form($tpl, $row)
	{
		$tpl = str_replace('{IN_FIRST_NAME}',$row["usr_first_name"], $tpl);
		$tpl = str_replace('{IN_LAST_NAME}',$row["usr_last_name"], $tpl);
		$tpl = str_replace('{IN_CURRPASSWORD}','', $tpl);
		$tpl = str_replace('{IN_NEWPASSWORD}','', $tpl);
		$tpl = str_replace('{IN_CONFPASSWORD}','', $tpl);
		$tpl = str_replace('{IN_EMAIL}',$row["usr_email"], $tpl);
		$tpl = str_replace('{IN_MOBILE}',$row["usr_mobile"], $tpl);
		 
		$tpl = str_replace('{IN_ICQ}',$row["usr_icq"], $tpl);
		$tpl = str_replace('{IN_URL}',$row["usr_url"], $tpl);
		$tpl = str_replace('{IN_COUNTRY}',$row["usr_country"], $tpl);
		$tpl = str_replace('{IN_INTERESTS}',$row["usr_interests"], $tpl);
		$tpl = str_replace('{IN_ABOUT}',$row["usr_about"], $tpl);
		
		return $tpl;
	} 
		
	$id = 11;
	$sql = "SELECT * FROM users WHERE usr_id = $id";
	$r = mysql_query($sql, $lnk);
	// echo '<br>'.$sql.'<br>';	
	$row = mysql_fetch_assoc($r);
	// echo mysql_errno($lnk).":".mysql_error($lnk);
	
	if ($_POST)
	{
	
	$in_first_name = $_POST["in_first_name"];
	$in_last_name = $_POST["in_last_name"];
	$in_email = $_POST["in_email"];
	$in_url = $_POST["in_url"];
	$in_icq = $_POST["in_icq"];
	$in_mobile = $_POST["in_mobile"];
	$in_about = $_POST["in_about"];
	$in_interests = $_POST["in_interests"];
	$in_country = $_POST["in_country"];
	
	
	$sql="UPDATE users 	SET usr_first_name ='$in_first_name',
							usr_last_name = '$in_last_name',
							usr_email = '$in_email',
							usr_url= '$in_url',
							usr_icq= '$in_icq',
							usr_mobile= '$in_mobile',
							usr_country = '$in_country',
							usr_interests= '$in_interests',							
							usr_about= '$in_about'
						where usr_id = '$id'";
	//echo '<br>'.$sql.'<br>';
	mysql_query($sql, $lnk);
	//echo mysql_errno($lnk).":".mysql_error($lnk);
	
	if (sha1($_POST["in_currpassword"])==$row["usr_password_hash"] 
			and strlen($_POST["in_newpassword"])!=0 
			and strlen($_POST["in_confpassword"])!=0
			and $_POST["in_confpassword"]==$_POST["in_newpassword"])
	{
	echo good;
	$password = sha1($_POST["in_confpassword"]);
	$sql="UPDATE users SET usr_password_hash = '$password' where usr_id='$id'";
	//echo '<br>'.$sql.'<br>';
	mysql_query($sql, $lnk);
	//echo mysql_errno($lnk).":".mysql_error($lnk);
	}

	}
	
	$sql = "SELECT * FROM users WHERE usr_id = $id";
	$r = mysql_query($sql, $lnk);
	$row = mysql_fetch_assoc($r);
	
	$out_tpl = '';
	$out_tpl = $out_tpl.get_form($user_page_tpl, $row);
		
	$main_tpl = str_replace('{TITLE}',"БИТ-форум - Настройки пользователя",$main_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $out_tpl, $main_tpl);
	
	echo $main_tpl;
		
?>