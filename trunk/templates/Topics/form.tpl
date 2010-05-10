<!-- <script language="javascript" type="text/javascript">var editor = new MessageEditor();</script> -->
 <form action="form_handler.php?forum={FORUM_ID}&topic={TOPIC_ID}" method="post">
	<table width="95%" align="center">
	  <tr class = "table_header">
		<td align = "center" colspan = "3"><b>{TITLE}</b></td>
	  </tr>
	  <tr class="message_header">
		<td align = "center"><b>Тема</b></td>
		<td>
			<input type="text" size="105" name="textfield" />
		</td>
		<td>&nbsp;</td>
	  </tr>
	  
	  <tr class = "message_text">
		<td width="25%">&nbsp;</td>
		<td width="1%" > 
		  <input type="button" id="set_bold_button" value="B" title="Bold text" 
				 onclick="javascript: editor.addTagsToMessage( '[b]', '[/b]' );" />
		  <input type="button" id="set_italic_button" value="I" title="Italic text"  
				 onclick="javascript: editor.addTagsToMessage( '[i]', '[/i]' );" />
		  <input type="button" id="add_quote_button" value="Quote" title="Quote text"  
				 onclick="javascript: editor.addTagsToMessage( '[quote]', '[/quote]' );" />
		  <input type="button" id="add_url_button" value="URL" title="Insert URL"  
				 onclick="javascript: editor.addTagsToMessage( '[url]', '[/url]' );" />
		  <input type="button" id="add_image_button" value="IMG" title="Insert image"  
				 onclick="javascript: editor.addTagsToMessage( '[img]', '[/img]' );" />
		</td>
		<td width="9%">&nbsp;</td>
	  </tr>
	  
	  <tr class = "message_text">
		<td valign = "top">Smilies: <br />
		  <img src="{ROOTPATH}images/smilies/icon_arrow.gif" width="15" height="15" 
			   title="Arrow" alt="Arrow"
			   onclick="javascipt: editor.addSmileToMessage( ':arrow:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_biggrin.gif" width="15" height="15" 
			   title="Very Happy" alt="Very Happy"
			   onclick="javascipt: editor.addSmileToMessage( ':D' );" />
		  <img src="{ROOTPATH}images/smilies/icon_confused.gif" width="15" height="15" 
			   title="Confused" alt="Confused"
			   onclick="javascipt: editor.addSmileToMessage( ':?' );" />
		  <img src="{ROOTPATH}images/smilies/icon_cool.gif" width="15" height="15" 
			   title="Cool" alt="Cool"
			   onclick="javascipt: editor.addSmileToMessage( '8)' );" />
		  <img src="{ROOTPATH}images/smilies/icon_cry.gif" width="15" height="15"
			   title="Cry" alt="Cry"
			   onclick="javascipt: editor.addSmileToMessage( ':cry:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_eek.gif" width="15" height="15" 
			   title="Shocked" alt="Shocked"
			   onclick="javascipt: editor.addSmileToMessage( '8O' );" />
		  <img src="{ROOTPATH}images/smilies/icon_evil.gif" width="15" height="15"
			   title="Evil" alt="Evil"
			   onclick="javascipt: editor.addSmileToMessage( ':evil:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_exclaim.gif" width="15" height="15" 
			   title="Exclaim" alt="Exclaim"
			   onclick="javascipt: editor.addSmileToMessage( ':!:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_frown.gif" width="15" height="15" 
			   title="Sad" alt="Sad"
			   onclick="javascipt: editor.addSmileToMessage( ':(' );" />
		  <img src="{ROOTPATH}images/smilies/icon_idea.gif" width="15" height="15"
			   title="Idea" alt="Idea"
			   onclick="javascipt: editor.addSmileToMessage( ':idea:' );"  />
		  <img src="{ROOTPATH}images/smilies/icon_lol.gif" width="15" height="15" 
			   title="Lol" alt="Lol"
			   onclick="javascipt: editor.addSmileToMessage( ':lol:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_mad.gif" width="15" height="15"
			   title="Mad" alt="Mad"
			   onclick="javascipt: editor.addSmileToMessage( ':x' );" />
		  <img src="{ROOTPATH}images/smilies/icon_mrgreen.gif" width="15" height="15" 
			   title="Mr. Green" alt="Mr. Green"
			   onclick="javascipt: editor.addSmileToMessage( ':mrgreen:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_neutral.gif" width="15" height="15" 
			   title="Neutral" alt="Neutral"
			   onclick="javascipt: editor.addSmileToMessage( ':|' );" />
		  <img src="{ROOTPATH}images/smilies/icon_question.gif" width="15" height="15" 
			   title="Question" alt="Question"
			   onclick="javascipt: editor.addSmileToMessage( ':?:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_razz.gif" width="15" height="15" 
			   title="Razz" alt="Razz"
			   onclick="javascipt: editor.addSmileToMessage( ':P' );" />
		  <img src="{ROOTPATH}images/smilies/icon_redface.gif" width="15" height="15" 
			   title="Embarassed" alt="Embarassed"
			   onclick="javascipt: editor.addSmileToMessage( ':oops:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_rolleyes.gif" width="15" height="15" 
			   title="Rolling Eyes" alt="Rolling Eyes"
			   onclick="javascipt: editor.addSmileToMessage( ':roll:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_smile.gif" width="15" height="15" 
			   title="Smile" alt="Smile"
			   onclick="javascipt: editor.addSmileToMessage( ':)' );" />
		  <img src="{ROOTPATH}images/smilies/icon_surprised.gif" width="15" height="15" 
			   title="Surprised" alt="Surprised"
			   onclick="javascipt: editor.addSmileToMessage( ':o' );" />
		  <img src="{ROOTPATH}images/smilies/icon_twisted.gif" width="15" height="15" 
			   title="Twisted Evil" alt="Twisted Evil"
			   onclick="javascipt: editor.addSmileToMessage( ':twisted:' );" />
		  <img src="{ROOTPATH}images/smilies/icon_wink.gif" width="15" height="15" 
			   title="Wink" alt="Wink"
			   onclick="javascipt: editor.addSmileToMessage( ';)' );" />
		</td>
		<td align = "center" rowspan="1">
		  <p>
			<textarea name="message_area" cols="91" rows="10" id="message_area" 
					onselect="javascript: editor.storeCaret();"
					onclick="javascript: editor.storeCaret();"
					onkeyup="javascript: editor.storeCaret();" ></textarea>		
			<script language="javascript" type="text/javascript">
			  editor.setTextArea("message_area");
			</script>  
		  </p>
		</td>
		<td>&nbsp;</td>
	  </tr>
	  
	   <tr class = "table_header">
		<td>&nbsp;</td>
		<td align = "center">
		  <input type="submit" value="Отправить" />
		  <input type="reset" value="Очистить" />
		</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
 </form>  
