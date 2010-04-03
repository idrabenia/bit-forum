/**
 * File contain util functions and classes for
 * message editor.
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


// function for store caret position
MessageEditor.prototype.storeCaret = function() {
    if (document.selection && document.selection.createRange 
            && this.textArea) {
		var textArea = this.textArea;
        textArea.caretPosition = document.selection.createRange().duplicate();	
    }
};


// function for insert text into text area around selected text or at end
MessageEditor.prototype.insertText = function(startText, endText) { 
    if (this.textArea != null && this.textArea.caretPosition) {
        this.textArea.caretPosition.text = startText 
            + this.textArea.caretPosition.text + endText;
	} 
    else if (this.textArea != null && this.textArea.selectionStart + 1 
            && this.textArea.selectionEnd + 1) {
        var textArea = this.textArea;
		var selectedText = textArea.value.substring(textArea.selectionStart, textArea.selectionEnd);
        textArea.value = textArea.value.substring(0, textArea.selectionStart) 
            + startText + selectedText + endText 
            + textArea.value.substring(textArea.selectionEnd, textArea.value.length);
	}
    else {
        this.textArea.value += startText + endText;
    }
};