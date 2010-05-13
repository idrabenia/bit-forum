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
		$tpl_password	=sha1($_POST["in_password1"]);
		$tpl_confirm  	=sha1($_POST["in_password2"]);
		$tpl_security	=$_POST["in_email"];
		$registr_date	=time();
		
		if ($tpl_password==$tpl_confirm)
		{
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
		$error = mysql_errno($lnk);
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