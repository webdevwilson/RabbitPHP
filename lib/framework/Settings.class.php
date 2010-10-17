<?php
/**
 * Defines Settings Object
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
class Settings {

  private $_settings;
  private static $_instance = false;

  private function __construct() {
    
    if( file_exists( APP_BASE . '/config/settings.ini' ) ) {
    	$this->_settings = parse_ini_file( APP_BASE . '/config/settings.ini', true );
    }
    
  }
  
  public static function instance() {
    
    if( ! Settings::$_instance ) {
    	Settings::$_instance = new Settings();
    }
    
    return Settings::$_instance;
    
  }
  
  public function get_all() {
  	return $this->_settings;
  }
  
  public function __get($name) {
  	return $this->_settings[$name];
  }

}

?>