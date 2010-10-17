<?php
/**
 * Defines UrlBuilder Object
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

class UrlBuilder extends Object {
	
	/**
	 * ControllerUrl builds the url to a controller
	 *
	 * @param array $params The array to use to build the url
	 * @returns string representation of the url
	 */
	public static function from_array( $params ) {
	  
	  $url_components = array();
	  
	  // Use plugin, if we need to
	  if( isset( $params['plugin'] ) ) {
	  	$url_components[] = $params['plugin'];
	  }

    if( $params['controller'] ) {
	  	
    	$url_components[] = $params['controller'];
    	
    	// Add action to components
    	if( isset($params['action']) && $params['action'] && ( $params['action'] != 'index' || isset($params['arg1']) ) ) {
    		$url_components[] = $params['action'];
    	}
    	
    	// add arg parameters ( arg1, arg2, arg3 )
    	$i = 1;
    	while( isset($params["arg$i"]) ) {
    		$url_components[] = $params["arg$i"];
    		$i++;
    	}
	  }
	  		
	  return '/'.implode('/',$url_components);
	  
	}

}

?>