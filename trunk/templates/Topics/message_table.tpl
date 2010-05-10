<table width="100%">
	<tr class="message_header">
		<td colspan="3" align="left" >{NUMBER_OF_MESSAGE}</td>
	</tr>
	<tr class="message_text">
		<td align="center"><b>{POSTER}</b></td>
		<td>Topic: {TOPIC_HEADER} </td>
		<td width="20%" align="center" >{MESSAGE_DATE}</td>
	</tr>
	<tr class="message_text">
		<td width="20%" align="center" valign="top">
			<table>
				<tr>
					<td align = "center" colspan = "2"><img src="./images/Avatars/20321.jpg" alt="User avatar" width="94" height="94" /></td>
				</tr>
				<tr class = "forum_description">
					<td align = "center">Messages:{MESS_COUNT}</td>
				</tr>
			</table>
		</td>
		<td colspan="2" valign="top" id="BTN_{NUMBER_OF_MESSAGE}" 
				name="BTN_{NUMBER_OF_MESSAGE}" >
			{MESSAGE_TEXT}
		</td>
	</tr>
	<tr class="message_text">
		<td>&nbsp;</td>
		<td>
			<a href="#top">Вверх</a>
			<a href="javascript: editor.insertQuote('BTN_{NUMBER_OF_MESSAGE}', '{POSTER}');" > 
				<img src="{ROOT_PATH}images/for_pages/post_quote.gif" alt="Цитата" border="0" /> 
			</a>
		</td>
		{DELETE_FORM}
	</tr>
	</form>
</table>