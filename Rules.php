<?php
	
	header('content-type: text/html; charset=utf8');

	require_once ("common.php");
	
	//----------------------------------GET TEMPLATES-----------------------------------//
	$main_tpl = file_get_contents('./templates/main.tpl');//Common template for all pages
	$rules_tpl = file_get_contents('./templates/User/rules.tpl');//List of rules with agreement
	
	
	$main_tpl = str_replace('{TITLE}',"БИТ-форум - Правила форума",$main_tpl);
	$main_tpl = str_replace('{ROOT_PATH}', ROOT_PATH, $main_tpl);
	$main_tpl = str_replace('{BODY}', $rules_tpl, $main_tpl);
		
	echo $main_tpl;

?> 