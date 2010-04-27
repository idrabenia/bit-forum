<?php
	header('Content-type: text/html; charset=utf-8');
	
	$lnk = mysql_connect('127.0.0.1', 'root', '1') or die ('could not connect');
	mysql_select_db('bit_forum', $lnk) or die ('no connection');
	
	$user_tpl_empty = file_get_contents('user_reg_empty.tpl');
	
	echo $user_tpl_empty;
		
	if ($_POST)
	{
		$tpl_login		=$_POST["in_login"];
		$tpl_email 		=$_POST["in_email"];
		$tpl_first_name =$_POST["in_first_name"];
		$tpl_last_name	=$_POST["in_last_name"];
		$tpl_password	=sha1($_POST["in_password1"]);
		$tpl_security	=$_POST["in_email"];
		$registr_date	=time();
		
		$sql = "INSERT INTO users (
									`usr_id`,
									`usr_login`,
									`usr_registr_date`,
									`usr_password_hash`,
									`usr_email`,
									`usr_role`,
									`usr_security_salt`,
									`usr_first_name`,
									`usr_last_name`
									)
								VALUES (
									NULL,
									'$tpl_login',
									'$registr_date',
									'$tpl_password',
									'$tpl_email',
									'2',
									'$tpl_security',
									'$tpl_first_name',
									'$tpl_last_name')";
									
		//echo '<br>'.$sql.'<br>';
		mysql_query($sql, $lnk);
		//echo mysql_errno($lnk).":".mysql_error($lnk);
	}
	
		
?>