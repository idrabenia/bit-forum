<a href="view_forums.php">На главную</a>
<table align="center" height="400"> <tr> <td>
<form action="" method="post">
    <table class="options_table" width="269" height="92" border="0" cellpadding="3" 
           cellspacing="0" >
        <tr>
            <td class="parameter_name" width="108">Login: </td>
            <td class="parameter_value" width="149">
                <input type="text" name="nickname" id="nickname" 
                       value="{NICKNAME_VALUE}" />
            </td>
        </tr>
        <tr>
            <td class="parameter_name">Password: </td>
            <td class="parameter_value">
                <input type="password" name="password" id="password" 
                       value="{PASSWORD_VALUE}" />
            </td>
        </tr>
        <tr>
            <td class="parameter_name">
                <span class="parameter_hint">
                    <label for="has_remember"> Remember me: </label>
                </span>
            </td>
            <td class="parameter_value">
                <input type="checkbox" id="has_remember" name="has_remember" 
                       value="has_remember" {REMEMBER_CHECK} />
            </td>
        </tr>
        <tr>
            <td align="center" class="parameter_name" colspan="2">
                <input name="login" type="submit" id="login" value="Login" />
            </td>
        </tr>
    </table>
</form>
</td></tr></table>