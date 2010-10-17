//document.write("<script type='text/javascript' src='/www/javascript/remote'></script>");

/** SiteNOW Javascript Library **/
var RemoteCall = Class.create();

RemoteCall = {
	
	initialize: function() {
		
	},
	
	update: function(ele,url,opts) {
		
		if( !opts ) { opts = new Object(); }
		if( !opts.requestHeaders ) { opts.requestHeaders = new Object(); }
		
		// hate using this method but in order to have the dashes...
		opts.requestHeaders['x-xhr-method'] = 'update';
		
		new Ajax.Updater(ele,url,opts);
	},
	execute: function(url,callback,opts) {
		
		if( !opts ) { opts = new Object(); }
		if( !opts.requestHeaders ) { opts.requestHeaders = new Object(); }
		
		// hate using this method but in order to have the dashes...
		opts.requestHeaders['x-xhr-method'] = 'execute';
		
		opts.onSuccess = function(transport,json) {
			callback( json );
		}
		new Ajax.Request(url,opts);
	}
	
}