<?php
/**
 * This file defines the SmartyFactory class, used to instantiate a smarty object
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

/**
 * Provides static create method to instantiate a smarty object
 * 
 * @uses Smarty
 */
class SmartyFactory {
  
  /**
   * retrieve a smarty object
   *
   * @return Smarty new smarty object
   */
  public static function create() {
  	
  	$smarty = new Smarty();
    $smarty->debugging = true;
    $smarty->template_dir = SMARTY_TEMPLATE_DIR;
    $smarty->compile_dir  = SMARTY_COMPILE_DIR;
    $smarty->plugins_dir  = ResourceLoader::instance()->get_smarty_plugin_directories();
		           
    return $smarty;
  }
}

?>