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

    this.textArea.value += ' ' + smileText + ' ';
}


MessageEditor.prototype.setTextArea = function(textAreaId) {
    var textArea = document.getElementById(textAreaId);
    if (textArea == null) {
		return;
	}
	
	this.textArea = textArea;
}

