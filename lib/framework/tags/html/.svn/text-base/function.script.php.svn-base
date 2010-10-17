<?php
/**
 * Defines the script smarty tag, which is used to load a javascript file
 * @package RabbitPHP_Tags
 * @subpackage Html
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_script($params,&$smarty) {
  
  $library = $params['library'];
  
  if( $params['library'] ) {
  	$smarty->_tpl_vars['rabbitphp_smartytags_script_html_scripts'][] = $library;
  }
  
}

?>