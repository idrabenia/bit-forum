{USER_LIST_PAGE}
    <!-- Menu table -->
    <table width="100%">
        <tr>
            <td>
                <a href="view_forums.php">На главную</a> 
                &nbsp;
                <a href="admin_panel.php">Страница администратора</a>
            </td>
            <td align="right">
                <a href="login_page.php?act=logout">Выход</a>
            </td>
        </tr>
    </table>

    <table> <!-- Table for input search keywords -->
      <tr>
        <td colspan="2">
          Введите логин пользователя
        </td>
      </tr>
      <tr>
        <form action="{CUR_PAGE_URL}" method="post">
          <td>
            <input type="text" name="keywords" value="{KEYWORDS}" />
          </td>
          <td>
            <input type="submit" name="submit" value="Искать" />
          </td>
        </form>
      </tr>
    </table>
    
    {NAVIGATION_TABLE}
    
    <!-- Header of found users table -->
    <table class="options_table"  width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th width="22%" class="parameter_name" scope="col"><b>Логин</b></th>
        <th width="19%" class="parameter_name" scope="col">
            <div align="center"><b>Дата регистрации</b></div>
        </th>
        <th width="30%" class="parameter_name" scope="col">
            <div align="center"><b>Группа</b></div>
        </th>
        <th class="parameter_name" colspan="3" scope="col">
            <div align="center"><b>Настройки</b></div>
        </th>
      </tr>
      {TABLE_ROWS}
      <tr>
        <td colspan="4" class="parameter_name" scope="row">&nbsp;</td>
      </tr>
    </table>
    
    {NAVIGATION_TABLE}
{EOT} <!-- End of template -- EOT -->


{LINK}
<a href="{PAGE_LINK}">{PAGE_DESC}</a>
{EOT}


{NAVIGATION_BAR}
    <!-- Navigation table -->
    <table align="center" >
      <tr>
        <td> {PREV_PAGE} </td>
        <td> {START_PAGE} </td>
        <td> {NEXT_PAGE} </td>
      </tr>
    </table>
{EOT}


{ODD_ROW}
<tr>

    <th class="odd_table_row" scope="row">
        <input type="checkbox" name="{USER_ID}" value="checkbox" id="{USER_ID}" />
        <label for="checkbox">{NICKNAME}</label>
    </th>

    <td class="odd_table_row">
        <div align="center">{REG_DATE}</div>
    </td>

    <td class="odd_table_row">
        <div align="center">{USER_ROLE}</div>
    </td>

    <td align="center" width="29%" class="odd_table_row">
      <div align="center">
        <a href="{USER_OPTIONS_PAGE}">
            <img src="{ROOT_PATH}images/for_pages/user_profile.gif" alt="Профиль" 
                 width="72" height="20" border="0" />
        </a>
      </div>
    </td>

</tr>
{EOT}


{NOT_ODD_ROW}
<tr>

    <th class="not_odd_table_row" scope="row">
        <input type="checkbox" name="{USER_ID}" value="checkbox" id="{USER_ID}" />
        <label for="{USER_ID}">{NICKNAME}</label>
    </th>

    <td class="not_odd_table_row">
        <div align="center">{REG_DATE}</div>
    </td>

    <td class="not_odd_table_row">
        <div align="center">{USER_ROLE}</div>
    </td>

    <td align="center" width="29%" class="not_odd_table_row">
      <div align="center">
        <a href="{USER_OPTIONS_PAGE}">
            <img src="{ROOT_PATH}images/for_pages/user_profile.gif" alt="Профиль" 
                 width="72" height="20" border="0" />
        </a>
      </div>
    </td>

</tr>
{EOT}

