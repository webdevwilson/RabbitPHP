<?php
/**
 * Defines the render_block smarty tag, which will render an element or view passing the body in as body
 *
 * <b>Parameters:</b><br />
 * element(optional) - The element to render, if not present attempts to use view parameter
 * view(optional) - The view to render in controller/view notation
 *
 * @package RabbitPHP_Tags
 * @subpackage Utility
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_block_render_block($params, $content, &$smarty, &$repeat) {
  
  if( !$repeat ) {
  	
	  if( isset( $params['element'] ) ) {
	  
	  	// Resolve element name
	  	$element = $params['element'];
	    unset( $params['element'] );
	  
	  	// get element file
	  	$render_file = ResourceLoader::instance()->get_element_file($element);
	  
		} else if ( isset( $params['view'] ) ) {
	  	
	  	// get view name
	  	$view = $params['view'];
	  	unset( $params['view'] );
	  	
	  	$render_file = ResourceLoader::instance()->get_view_file($view);
	  }
	  
	  if( $render_file ) {
	    	
	    	// get smarty template vars, so we can restore in case of overwrite
	    	$restore_vars = array();
	    	foreach( $smarty->get_template_vars() AS $var => $value ) {
	    		$restore_vars[$var] = $value;
	    	}
	    
	    	// assign passed parameters
	    	foreach( $params AS $param => $value ) {
	    		$smarty->assign( $param, $value );
	    	}
	    	
	    	$smarty->assign('body', $content);
	    	
	    	echo $smarty->fetch('file:'.$render_file);
	    
	    	// clear passed parameters assigned
	    	foreach( $params AS $param => $value ) {
	    		$smarty->clear_assign($param);
	    	}
	    
	    	// reassign old in case of conflict
	    	foreach( $restore_vars AS $name => $value ) {
	    		$smarty->assign( $name, $value );
	    	}
	    
		} else {
	  		
			// element file was not found
	  	echo '<strong>'.$element . ' not found.</strong>';
		}
	}
}

?>