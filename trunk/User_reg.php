<?php
	header('Content-type: text/html; charset=utf-8');

	require_once ("common.php");
	
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages
	$reg_tpl = file_get_contents('./templates/User/user_reg.tpl');//Registration form
	
	
	$lnk = mysql_connect('127.0.0.1', 'root', '1') or die ('could not connect');
	mysql_select_db('bit_forum', $lnk) or die ('no connection');
	
	
	$main_tpl = str_replace('{TITLE}',"БИТ-форум - Регистрация",$main_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $reg_tpl, $main_tpl);
	
	echo $main_tpl;
		
	if (isset($_POST["in_login"]))
	{
		$tpl_login		=$_POST["in_login"];
		$tpl_email 		=$_POST["in_email"];
		$tpl_first_name =$_POST["in_first_name"];
		$tpl_last_name	=$_POST["in_last_name"];
		$tpl_password	=$_POST["in_password1"];
		$tpl_confirm  	=$_POST["in_password2"];
		
		$registr_date	=time();
		$salt			=$registr_date*2;
		
		if ($tpl_password==$tpl_confirm)
		{
		 $pass_hash		=sha1(sha1($tpl_password).$salt);
		 $sql = "INSERT INTO users (
									`usr_id`,
									`usr_login`,
									`usr_registr_date`,
									`usr_password_hash`,
									`usr_email`,
									`usr_role`,
									`usr_security_salt`,
									`usr_first_name`,
									`usr_last_name`,
									`usr_avatar`
									)
								VALUES (
									NULL,
									'$tpl_login',
									'$registr_date',
									'$pass_hash',
									'$tpl_email',
									'2',
									'$salt',
									'$tpl_first_name',
									'$tpl_last_name',
									'./images/avatars/default.jpg'
									)";
									
		echo '<br>'.$sql.'<br>';
		mysql_query($sql, $lnk);
		
		$error = mysql_errno($lnk);
		echo mysql_errno($lnk).":".mysql_error($lnk);
		}
		else
		{
		$error = 1;
		}
		
		//echo $error;
		if (0==$error)
		{
		echo "Registration was successful";
		}
		else
		{
		echo "Registration was unsuccessful";
		}
		//echo mysql_errno($lnk).":".mysql_error($lnk);
	}
	
		
?>