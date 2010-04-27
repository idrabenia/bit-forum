<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Настройки пользователя</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="admin_panel.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript" src="form_check.js"></script>
</head>
<body>

	<p align="center" class="error_message" id="form_error"></p>
	<script language="javascript" type="text/javascript">
		var formValidator = new FormValidator("form_error");
	</script>

<form id="form1" name="user_page" method="post" action="user_page.php">
	<table class="settings_table"  width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2" align="center" class="parameter_name">
			<label><b>User's settings</b></label>
		</td>
	</tr>
    <tr>
		<td colspan="2" align="center" class="parameter_value">
			<label><b>Private information</b></label>
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>First Name</b>
		</td>
        <td class="parameter_value" scope="col">
			<input type="text" name="in_first_name" value="{IN_FIRST_NAME}" id="in_first_name" />
			<span class="error_message" id="in_first_name_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^([A-Za-z])+$/
					formValidator.addField("in_first_name", regExp, "in_first_name_error");
				</script>			
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>Last Name</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_last_name" value="{IN_LAST_NAME}" id="in_last_name" />
			<span class="error_message" id="in_last_name_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^([A-Za-z])+$/
					formValidator.addField("in_last_name", regExp, "in_last_name_error");
				</script>			
		</td>	
	</tr>
	<tr>
		<td colspan="2" align="center" class="parameter_value">
			<b>Password settings</b>
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>Current password</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_currpassword" value="{IN_CURRPASSWORD}" id="in_currpassword" />
			<span class="error_message" id="in_currpassword_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^[A-z0-9_\-]{6,30}$/
					formValidator.addField("in_currpassword", regExp, "in_currpassword_error");
				</script>			
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>New password</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_newpassword" value="{IN_NEWPASSWORD}" id="in_newpassword" />
			<span class="error_message" id="in_newpassword_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^[A-z0-9_\-]{6,30}$/
					formValidator.addField("in_newpassword", regExp, "in_newpassword_error");
				</script>			
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>Confirm password</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_confpassword" value="{IN_CONFPASSWORD}" id="in_confpassword" />
			<span class="error_message" id="in_confpassword_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^[A-z0-9_\-]{6,30}$/
					formValidator.addField("in_confpassword", regExp, "in_confpassword_error");
				</script>			
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="parameter_value">
			<b>Profile settings</b>
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>E-mail</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_email" value="{IN_EMAIL}" id="in_email" />	
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>Mobile</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_mobile" value="{IN_MOBILE}" id="in_mobile" />
			<span class="error_message" id="in_mobile_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^[0-9]{1,20}$/
					formValidator.addField("in_mobile", regExp, "in_mobile_error");
				</script>			
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>ICQ</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_icq" value="{IN_ICQ}" id="in_icq" />
			<span class="error_message" id="in_icq_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^[0-9]{1,9}$/
					formValidator.addField("in_icq", regExp, "in_icq_error");
				</script>			
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>URL</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_url" value="{IN_URL}" id="in_url" />	
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>Country</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_country" value="{IN_COUNTRY}" id="in_country" />
			<span class="error_message" id="in_country_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^([A-Za-z])+$/
					formValidator.addField("in_country", regExp, "in_country_error");
				</script>			
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="parameter_value">
			<b>Avatar</b>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="parameter_value">
			<b>About</b>
		</td>
	</tr>
	<tr>
	    <td class="parameter_name" scope="col">
			<b>Interests</b>
		</td> 
        <td class="parameter_value" scope="col">
			<textarea type="text" name="in_interests" id="in_interests">{IN_INTERESTS}</textarea>
			
			
		</td>
	</tr>
		<tr>
	    <td class="parameter_name" scope="col">
			<b>About me</b>
		</td> 
        <td class="parameter_value" scope="col">
			<textarea type="text" name="in_about" id="in_about">{IN_ABOUT}</textarea>
			
			
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="parameter_name">
				<input type="submit" value="I agree" name="submit_button" />
				<input type="reset" value="Cancel" name="reset_button" />
		</td>
	</tr> 
	</table>
</form>
</body>
</html>