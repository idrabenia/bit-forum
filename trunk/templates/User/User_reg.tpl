<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Регистрация нового пользователя</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="admin_panel.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript" src="form_check.js"></script>
</head>

<body>

	<p align="center" class="error_message" id="form_error"></p>
	<script language="javascript" type="text/javascript">
		var formValidator = new FormValidator("form_error");
	</script>

<form id="form1" name="user_reg" method="post" action="">
	<table class="options_table"  width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
			<td colspan="2" align="center" class="parameter_name">
				<label><b>Registration</b></label>
			</td>
	  </tr>
      <tr>
			<td class="parameter_name" scope="col">
				<b>Login</b>
			</td>
			<td class="parameter_value" scope="col">
				<input type="text" name="in_login" value="{IN_LOGIN}" id="in_login" />
				<span class="error_message" id="in_login_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^([A-Za-z0-9_-]+\.)*[A-Za-z0-9_-]+$/
					formValidator.addField("in_login", regExp, "in_login_error");
				</script>
			</td>
	  </tr>
	  <tr>
	    <td class="parameter_name" scope="col">
			<b>E-Mail</b>
		</td>
        <td class="parameter_value" scope="col">
			<input type="text" name="in_email" value="{IN_EMAIL}" id="in_email" />
			<span class="error_message" id="in_email_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp
						= /^([A-z0-9_\-]+\.)*[A-z0-9_\-]+@([A-z0-9][A-z0-9\-]*[A-z0-9]\.)+[A-z]{2,4}$/
					formValidator.addField("in_email", regExp, "in_email_error");
				</script>
		</td>
	  </tr>
	  <tr>
	    <td class="parameter_name" scope="col">
			<b>First Name</b>
		</td>
        <td class="parameter_value" scope="col">
			<input type="text" name="in_firstname" value="{IN_FIRST_NAME}" id="in_first_name" />		
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
			<input type="text" name="in_lastname" value="{IN_LAST_NAME}" id="in_last_name" />
			<span class="error_message" id="in_last_name_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp = /^([A-Za-z])+$/
					formValidator.addField("in_last_name", regExp, "in_last_name_error");
				</script>			
		</td>
	  </tr>
	  <tr>
	    <td class="parameter_name" scope="col">
			<b>Password</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_password1" value="{IN_PASSWORD1}" id="in_password1" />		
			<span class="error_message" id="in_password1_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp
						= /^[A-z0-9_\-]{6,30}$/
					formValidator.addField("in_password1", regExp, "in_password1_error");
				</script>
		</td>
		</tr>
	  <tr>
	    <td class="parameter_name" scope="col">
			<b>Confirm Password</b>
		</td> 
        <td class="parameter_value" scope="col">
			<input type="text" name="in_password2" value="{IN_PASSWORD2}" id="password2" />
			<span class="error_message" id="in_password2_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp
						= /^[A-z0-9_\-]{6,30}$/
					formValidator.addField("in_password2", regExp, "in_password2_error");
				</script>			
		</td>
	  </tr>
	  <tr>
		<td colspan="2" align="center" class="parameter_name">
				<input type="submit" value="Next" name="submit_button"/>
				<input type="reset" value="Reset" name="reset_button" />
		</td>
	  </tr>  
	</table>
</form>
</body>
</html>
