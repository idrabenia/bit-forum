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
		<td width="20%" align="center"><img src="./images/Avatars/20321.jpg" alt="User avatar" width="94" height="94" /></td>
		<td colspan="2" valign="top">{MESSAGE_TEXT}</td>
	</tr>
	<form id="form2" name="form2" method="post" action="view_posts.php">
	<tr class="message_text">
		<td>&nbsp;</td>
		<td colspan="2" >
			<input type="submit" name="Submit3" value="Delete" />
			<input type="hidden" name="mes_id" value="{MESSAGE_ID}" /></td>
	</tr>
	</form>
</table>