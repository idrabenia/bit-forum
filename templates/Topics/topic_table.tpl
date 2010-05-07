 <table width="100%" cellspacing="1">
	 <tr class="message_text">
	    <td width="5%" align="center"><img src="./images/for_pages/topic_read.gif" alt="Topic" width="19" height="18" /></td>
	    <td width="65%"><a href="view_posts.php?forum={FORUM_ID}&topic={TOPIC_ID}">{TOPIC_TITLE}</a></td>
		<form id="form2" name="form2" method="post" action="view_topics.php?forum={FORUM_ID}">
		<td width="10%" align="center">
			<input type="submit" name="Submit3" value="Delete" />
			<input type="hidden" name="top_id" value="{TOPIC_ID}" /></td>
		</form>
	    <td width="20%" align="center" >{TOPIC_CREATOR}</td>
	  </tr>
 </table>