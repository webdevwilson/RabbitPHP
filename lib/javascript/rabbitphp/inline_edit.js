// inline edit script
// requires prototype
// <span id='email_address' class='inline-edit-textfield'>

var InlineEditField = Class.create();

InlineEditField.prototype = {
  
	initialize: function(ele) {
		
		Event.observe(ele,'click',this.edit);
		
		ele.style.cursor='pointer';
		ele.title='Click to Edit';
	},
	
	edit: function() {
			
		  var text = this.innerHTML;
		  
		  this.innerHTML = '';
		  
		  var field = document.createElement('input');
		  Element.extend( field );
		  
		  field.type = 'text';
		  field.value = text;
		  
		  this.appendChild( field );
		  
		  Event.stopObserving(this,'click',this.edit);
	}
	
}

Event.observe(window,'load',function() {
	var spans = document.getElementsByClassName('inline-edit-textfield');
	for( var i = 0; i < spans.length; i++ ) {
		new InlineEditField(spans[i]);
	}
	
});