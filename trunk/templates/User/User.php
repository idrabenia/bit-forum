<?php
	header('Content-type: text/html; charset=utf-8');
	
	$lnk = mysql_connect('127.0.0.1', 'root', '1') or die ('could not connect');
	mysql_select_db('bit_forum', $lnk) or die ('no connection');
	
	//$user_tpl_empty = file_get_contents('user_reg_empty.tpl');
	//$user_tpl_reg = file_get_contents('user_reg_reg.tpl');
	//echo $user_tpl_empty;
		
	if (isset($_POST["in_login"]))
	{
		$in_login		=$_POST["in_login"];
		$in_email 		=$_POST["in_email"];
		$in_first_name 	=$_POST["in_first_name"];
		$in_last_name	=$_POST["in_last_name"];
		$in_password	=$_POST["in_password"];
		$in_security	='secutiry';
		//echo $login;
		//mysql_query("INSERT INTO users VALUES (NULL, $login, mail, 'EMAIL', '2', 'f')", $lnk);
		$sql="INSERT INTO users VALUES (	NULL, 
											'$in_login', 
											'$in_password', 
											'$in_email', 
											'2', 
											'in_security')";
		//echo '<br>'.$sql.'<br>';
		mysql_query($sql, $lnk);
	}
	//echo mysql_errno($lnk).":".mysql_error($lnk);
		
?>