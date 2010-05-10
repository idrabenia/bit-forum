/**
 * File contain util functions and classes for
 * message editor.
 * @author Ilya G. Drobenya
 */
 
 
/**
 * MessageEditor represent message editor :)
 */
function MessageEditor() {
    this.textArea = null;
}


MessageEditor.prototype.addSmileToMessage = function(smileText) {
    if (this.textArea == null) {
        return;
    }

    this.insertText('', ' ' + smileText + ' ');
};


MessageEditor.prototype.addTagsToMessage = function(startTag, endTag) {
    if (this.textArea == null) {
        return;
    }

    this.insertText(startTag, endTag);
};


MessageEditor.prototype.setTextArea = function(textAreaId) {
    var textArea = document.getElementById(textAreaId);
    if (textArea == null) {
        return;
    }
    
    this.textArea = textArea;
};


/**
 *  function for store caret position
 */
MessageEditor.prototype.storeCaret = function() {
    if (document.selection && document.selection.createRange 
            && this.textArea) {
        var textArea = this.textArea;
        textArea.caretPosition = document.selection.createRange()
            .duplicate();
    }
};


/** 
 * Function for insert text into 
 * text area around selected text or at end
 */
MessageEditor.prototype.insertText = function(startText, endText) { 
    if (this.textArea != null && this.textArea.caretPosition) {
        this.textArea.caretPosition.text = startText 
            + this.textArea.caretPosition.text + endText;
    } 
    else if (this.textArea != null && this.textArea.selectionStart + 1 
            && this.textArea.selectionEnd + 1) {
        var textArea = this.textArea;
				
		var selectStart = textArea.selectionStart;
		var selectEnd = textArea.selectionEnd;
				
        var oldText = textArea.value;
        var selectedText = oldText.substring(selectStart, selectEnd);

        textArea.value = oldText.substring(0, selectStart);
        textArea.value += startText + selectedText + endText; 
        textArea.value += oldText.substring(
        	selectEnd, oldText.length);
    }
    else {
        this.textArea.value += startText + endText;
    }
};


/**
 * Method replace html-tags on corresponding bbcodes
 * @param {String} text message with html tags
 * @return {String} message with bbcodes
 */
MessageEditor.prototype.htmlToBbcodes = function(text) {
	text = text.replace(/(<br)(.*?)((>)|(\/>))/mgi, "\n");
	
	// replace tags to bbcodes 
	do {
		var oldText = text;
		
		// quotes to bbcodes
		text = text.replace(/<div((.|\n)*?)>((.|\n)*?)<\/div>/mgi, 
			"[quote]$3[/quote]");
		
		// references to bbcodes
		text = text.replace(/<a href="(.*?)">(.*?)<\/a>/mgi, 
			'[url=$1]$2[/url]');
		
		// images to bbcodes
		text = text.replace(/<img src="(.*?)"(.*?)(\/?)>/mgi, 
			'[img]$1[/img]');
		
		// bold/italic to bbcodes
		text = text.replace(/<(b|i)>((.|\n|\r|\r\n)*?)<\/(b|i)>/mgi, 
			'[$1]$2[/$1]');
	} while (oldText !== text);

	// strip tags and add quote bbcodes
	text = text.replace(/(^\s+)|(\s+$)/g, "");
	text = text.replace(/\<.*?\>/g, "");
	
	return text;
}; // htmlToBbcodes


/**
 * Function for insert other user message into editor.
 * 
 * @param {String} messageCellId Id of table cell with 
 * user message
 * @param {String} senderLogin Login of current message
 * sender
 */
MessageEditor.prototype.insertQuote = function(messageCellId, 
		senderLogin) {
	var messageCell = document.getElementById(messageCellId);
	
	if (this.textArea === null) {
		return;
	}
	
	// retrieve selected text 
	var text = '';
	if (document.getSelection !== undefined 
			&& document.getSelection() !== "") {
		// For FF
		text = document.getSelection();
	}
	else if (document.selection !== undefined
			&& document.selection.createRange !== undefined) {
		// For IE
		text = document.selection.createRange().text;
		
		if (text === "") {
			text = messageCell.innerHTML;
		}
	}
	else {
		text = messageCell.innerHTML;
	}
	
	text = this.htmlToBbcodes(text);

	this.textArea.value += '[quote=' + senderLogin + ']';
	this.textArea.value += text;
	this.textArea.value += '[/quote]\n';
};

