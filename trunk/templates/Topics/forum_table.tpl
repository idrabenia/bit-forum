<table width="100%" cellspacing="1">
	 <tr class="message_text">
	    <td width="5%" align="center"><img src="./images/for_pages/forum_read.gif" alt="forum" width="46" height="25" /></td>
		<td width="60%" >
		<table>
			<tr>
				<td><a href="view_topics.php?forum={FORUM_ID}">{FORUM_TITLE}</a></td>
			</tr>
			<tr class="forum_description">
				<td>{FORUM_DESCRIPTION}</td>
			</tr>
		</table></td>
		<form id="form2" name="form2" method="post" action="view_forums.php">
		<td width="15%" align="center">
			<input type="submit" name="Submit3" value="Delete" />
			<input type="hidden" name="top_id" value="{FORUM_ID}" /></td>
		</form>
	    <td width="20%" align="center" >{FORUM_MODERATOR}</td>
	  </tr>
 </table>