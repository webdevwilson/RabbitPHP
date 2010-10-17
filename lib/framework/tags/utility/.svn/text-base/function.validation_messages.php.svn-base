<?php
/**
 * Defines the validation_messages smarty tag, which will render validation messages
 *
 * <b>Parameters:</b><br />
 * element - The element to render
 *
 * @package RabbitPHP_Tags
 * @subpackage Utility
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_validation_messages($params,&$smarty) {
  
  // Resolve element name
  $element = 'validation_messages';
  if( isset( $params['element'] ) ) {
    $element = $params['element'];
    unset( $params['element'] );
  }
  
  $element_file = ResourceLoader::instance()->get_element_file($element);
  
  if( $element && $element_file ) {
    
    // Assign passed parameters
    foreach( $params AS $param => $value ) {
    	$smarty->assign( $param, $value );
    }
    
    // Resolve model and retrieve messages
    $model_args = explode('.',$params['model']);
    list($model_name,$model_field) = $model_args;
    
    $model = $smarty->get_template_vars($model_name);
    if( $model ) {
    	
    	$messages = $model->validation_messages[$model_field];
    	$smarty->assign('messages', $messages );
      echo $smarty->fetch('file:'.$element_file);
      $smarty->clear_assign('messages');
    }
    
    // Clear assigned
    foreach( $params AS $param => $value ) {
    	$smarty->clear_assign($param);
    }
    
  } else {
  	echo '<strong>'.$element . ' element not found.</strong>';
  }
  
}

?>