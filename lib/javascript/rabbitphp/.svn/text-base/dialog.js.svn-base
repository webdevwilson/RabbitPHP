var Dialog = Class.create();

Dialog.prototype = {
	
	dialog: false,
	bground: false,
	open: false,
	
	initialize: function() {
    
    // Set up dialog and grab contents
    this.dialog = document.createElement('div');
    Element.extend( this.dialog );
    this.dialog.setStyle( {
      position: 'absolute',
      top: '150px',
      zIndex: 10 
    } );
    this.dialog.addClassName('dialog');
    
  	// Setup background
    this.bground = document.createElement("div");
		Element.extend( this.bground );
		this.bground.id = "alert-message";
		this.bground.setStyle( {
			position: 'absolute',
			top: '0px',
			left: '0px',
			zIndex: 5,
			backgroundColor: '#000',
			opacity: '.9'
		});
		
  },
	
	show: function() {
		if( ! this.open ) {
			document.body.appendChild(this.dialog);
			document.body.appendChild(this.bground);
			this.center();
			this.open = true;
			Event.observe(window,'resize', function() { dialog.center(); });
		}
	},
	
	hide: function() {
		if( this.open ) {
			this.dialog.remove();
			this.bground.remove();
			this.open = false;
			Event.stopObserving(window,'resize',function() { dialog.center(); });
		}
	},
	
	center: function() {
		
		// get center of page
  	var pageCenter = ( document.body.clientWidth + document.body.scrollLeft ) / 2;
  	if ( navigator.userAgent.toLowerCase().indexOf("safari")!=-1 ) {
    	pageCenter = ( document.body.offsetWidth / 2 );
    }
    
    // position dialog
    this.dialog.style.left = pageCenter - ( this.dialog.getWidth() / 2 )+'px';
    
    this.bground.style.width = ( document.body.clientWidth + document.body.scrollLeft )+'px';
    this.bground.style.height = ( document.body.clientHeight + document.body.scrollTop )+'px';
    
  },
  
  update: function(url,options) {
  	
  	if( !options ) { options = new Object(); }
  	
  	if(! options.method ) {
  		options.method = 'GET';
		}
  	
  	var onComplete = options.onComplete || Prototype.emptyFunction;
    options.onComplete = function(transport, param) {
      this.dialog.show();
      onComplete(transport, param);
    }
  	
  	RemoteCall.update(this.dialog,url,options);
  }
	
}