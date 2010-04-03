// JavaScript Document

function Validator(outputControlId) {
	var outputControl = document.getElementById(outputControlId);
	if (outputControl != null) {
		this.outputControl = outputControl;
		this.outputControlText = outputControl.innerHTML;
	}
}

Validator.prototype.run = function () {
	
};

/** Define TextValidator class */
function TextValidator(inputControlId, regExpPattern, outputControlId) {	
	Validator.call(this, outputControlId);
	var inputControl = document.getElementById(inputControlId);
	if (inputControl != null)
		this.inputControl = inputControl;
	this.regExpPattern = regExpPattern;
}

TextValidator.prototype = new Validator(null);
TextValidator.prototype.constructor = TextValidator;
TextValidator.prototype.run = function() {
	var pattern = this.regExpPattern;
	var textValue = this.inputControl.value;
	if ( !pattern.test(textValue) ) {
		this.outputControl.innerHTML = "*";
		return false;
	}

	this.outputControl.innerHTML = this.outputControlText;
	return true;	
};


/** Define FormValidator class */
function FormValidator(outputControlId) {
	Validator.call(this, outputControlId);
	this.fieldValidators = [];
}

FormValidator.prototype = new Validator(null);
FormValidator.prototype.constructor = FormValidator;

FormValidator.prototype.run = function () {
	var isFormValid = true;
	var out = this.outputControl;

	out.innerHTML = this.outputControlText;
	for (var i = 0; i < this.fieldValidators.length; ++i) {
		var curValidator = this.fieldValidators[i];
		if ( curValidator.run() == false )
		{
			out.innerHTML = out.innerHTML +"<br />Field " 
				+ curValidator.inputControl.name + " has invalid value."; 
			isFormValid = false;
		}
	}

	return isFormValid;
};

FormValidator.prototype.addField = function (fieldId, regexpPattern, errorOutputId) {
	var newValidator = null;
	newValidator = new TextValidator(fieldId, regexpPattern, errorOutputId);
	
	newValidator.inputControl.onkeyup = function () {
		newValidator.run();
	};
	
	this.fieldValidators.push( newValidator );
};