<?php
/**
 * Defines the script_export smarty tag, which is used to export variables to javascript
 * @package RabbitPHP_Tags
 * @subpackage Html
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_script_export($params,&$smarty) {
  
  if( is_array( $params ) && count( $params ) > 0 ) {
    
    $html  = '<script type=\'text/javascript\'>';
    foreach( $params AS $key => $value ) {
      $html .= 'var '.$key.'='.HtmlBuilder::javascript_export($value).';';
    }
    $html .= '</script>';
    return $html; 	
  }
}

?>