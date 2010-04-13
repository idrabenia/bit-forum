<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf8" />
	<title>Панель администратора</title>
	<meta http-equiv="" content="text/html; charset=utf-8" />
	<meta http-equiv="Выберите расширение для паковки" content="text/html; charset=utf-8" />
	<meta http-equiv="Выберите расширение для паковки" content="text/html; charset=utf-8" />
    <link href="./templates/styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript" src="./templates/Admin/form_check.js">
	</script>
</head>

<body>	
	<p align="center" class="error_message" id="form_error"></p>
	<script language="javascript" type="text/javascript">
		var formValidator = new FormValidator("form_error");
	</script>
	
	<form method="post" action="." onsubmit="return formValidator.run();" >	
		<table width="100%" border="1" cellpadding="0" cellspacing="0" 
			   class="options_table">
		  <tr>
		    <td colspan="2" class="parameter_name">&nbsp;</td>
	      </tr>
		  <tr>
			<td width="26%" class="parameter_name"><b>Длина логина</b></td>
			<td width="74%" class="parameter_value">
				Минимум:  
				<input type="text" name="login_size_min" id="login_size_min" 
					   value="{MIN_LOGIN_SIZE}" size="10"  /> 
				<span class="error_message" id="login_size_min_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					formValidator.addField("login_size_min", /^(\d){1,2}$/, "login_size_min_error");
				</script>
				
				Максимум:
				<input type="text" name="login_size_max" id="login_size_max" 
					   value="{MAX_LOGIN_SIZE}" size="10" /> 
				<span class="error_message" id="login_size_max_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					formValidator.addField("login_size_max", /^(\d){1,2}$/, "login_size_max_error");
				</script>			
            </td>
		  </tr>
		  <tr>
			<td class="parameter_name"><b>Длина пароля </b></td>
			<td class="parameter_value">
				Минимум: 
				<input type="text" name="password_size_min" id="password_size_min" 
					   value="{MIN_PASSWORD_SIZE}" size="10" />
				<span class="error_message" id="password_size_min_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					formValidator.addField("password_size_min", /^(\d){1,2}$/,
							"password_size_min_error");
				</script>
				 
				Максимум:
				<input type="text" name="password_size_max" id="password_size_max"
						           value="{MAX_PASSWORD_SIZE}" size="10" /> 
				<span class="error_message" id="password_size_max_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					formValidator.addField("password_size_max", /^(\d){1,2}$/,
							"password_size_max_error");
				</script>			</td>
		  </tr>
		  <tr>
			<td class="parameter_name"><b>Активация аккаунта</b> </td>
			<td class="parameter_value">
				<input type="radio" name="account_activation" value="NO_ACCOUNT_ACTIVATION" 
				                    id="radio_none_account_activation" {NO_ACCOUNT_ACTIVATION} />
				<label for="radio_none_account_activation">Нет</label>
				
				<input type="radio" name="account_activation" value="DISABLED_ACCOUNT_ACTIVATION" 
									id="radio_disabled_account_activation" 
									{DISABLED_ACCOUNT_ACTIVATION} />
				<label for="radio_disabled_account_activation">Отключена</label>
				
				<input type="radio" name="account_activation" value="EMAIL_ACCOUNT_ACTIVATION" 
									id="radio_email_account_activation" 
									{EMAIL_ACCOUNT_ACTIVATION} />
				<label for="radio_email_account_activation">По email</label>
			</td>
		  </tr>
		  <tr>
			<td class="parameter_name">
				<b>Время действия пароля</b> <br />
				<small class="parameter_hint">Если 0, то время действия неограничено</small>			</td>
			<td class="parameter_value">
				<input type="text" size="10" name="password_action_time" 
								   id="password_action_time" value="{PASSW_ACTION_TIME}" />
				Дней
				<span class="error_message" id="password_action_time_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					formValidator.addField("password_action_time", /^(\d){1,3}$/,
							"password_action_time_error");
				</script>			</td>
		  </tr>
		  <tr>
			<td class="parameter_name">
				<b>Сложность пароля</b>			</td>
			<td class="parameter_value">
				<select name="password_complexity">
					<option value="NO_PASSW_COMPLEX" {NO_PASSW_COMPLEX}>
						Любые символы, начиная с буквы
					</option>
					<option value="REGISTER_PASSW_COMPLEX" {REGISTER_PASSW_COMPLEX}>
						Должно быть чередования регистров
					</option>
					<option value="DIGIT_PASSW_COMPLEX" {DIGIT_PASSW_COMPLEX}>
						Должны быть цифры
					</option>
					<option value="DIGIT_REGISTER_PASSW_COMPLEX" {DIGIT_REGISTER_PASSW_COMPLEX}>
						Должно быть чередования регистров и цифры
					</option>
				</select>
			</td>
		  </tr>
		  <tr>
			<td class="parameter_name"><b>Загрузка аватаров</b> </td>
			<td class="parameter_value">
				<input type="radio" name="avatar_upload" value="ENABLED_AVATARS" 
				                    id="radio_enabled_avatar_upload" {ENABLED_AVATARS} />
				<label for="radio_enabled_avatar_upload">Включить</label>
				
				<input type="radio" name="avatar_upload" value="DISABLED_AVATARS" 
									id="radio_disabled_avatar_upload" {DISABLED_AVATARS} />
				<label for="radio_disabled_avatar_upload">Отключить</label>			</td>
		  </tr>
		  <tr>
			<td class="parameter_name"><b>Папка для хранения картинок</b></td>
			<td class="parameter_value">
				<input type="text" size="15" name="image_store_path" value="{IMAGES_PATH}" />
			</td>
		  </tr>
		  <tr>
			<td class="parameter_name"><b>Email администратора</b> </td>
			<td class="parameter_value">
				<input type="text" name="admin_email" id="admin_email"  value="{ADMINS_EMAIL}" />
				<span class="error_message" id="admin_email_error">&nbsp;&nbsp;</span>
				<script type="text/javascript">
					var regExp
						= /^([A-z0-9_\-]+\.)*[A-z0-9_\-]+@([A-z0-9][A-z0-9\-]*[A-z0-9]\.)+[A-z]{2,4}$/
					formValidator.addField("admin_email", regExp, "admin_email_error");
				</script>
			</td>
		  </tr>
		  <tr>
			<td colspan="2" align="center" class="parameter_name">
				<input type="submit" value="Сохранить" name="submit_button"/>
				<input type="reset" value="Отменить" name="reset_button" />
			</td>
		  </tr>
	  </table>
	</form>
</body>
</html>
