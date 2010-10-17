<?php
/**
 * Defines the render_element smarty tag, which will render an element, this tag is deprecated and will be removed
 *
 * <b>Parameters:</b><br />
 * element - The element to render
 *
 * @package RabbitPHP_Tags
 * @subpackage Utility
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_render_element($params,&$smarty) {
  
  // Resolve element name
  $element = false;
  if( isset( $params['element'] ) ) {
    $element = $params['element'];
    unset( $params['element'] );
  }
  
  $element_file = ResourceLoader::instance()->get_element_file($element);
  
  if( $element && $element_file ) {
    
    // get smarty template vars, so we can restore in case of overwrite
    $restore_vars = array();
    foreach( $smarty->get_template_vars() AS $var => $value ) {
    	$restore_vars[$var] = $value;
    }
    
    // assign passed parameters
    foreach( $params AS $param => $value ) {
    	$smarty->assign( $param, $value );
    }
    
    echo $smarty->fetch('file:'.$element_file);
    
    // clear passed parameters assigned
    foreach( $params AS $param => $value ) {
    	$smarty->clear_assign($param);
    }
    
    // reassign old in case of conflict
    foreach( $restore_vars AS $name => $value ) {
    	$smarty->assign( $name, $value );
    }
    
  } else {
  	echo '<strong>'.$element . ' element not found.</strong>';
  }
  
}

?>