<?php
/**
 * Defines Flash Object
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

/**
 * Provides Flash Scope
 * 
 * Flash scope
 * 
 * @uses Session
 * @uses CookieCollection
 */
class Flash extends DynamicObject {
  
  private $session;
  
  /**
   * Flash constructor
   *
   * @param Session $session The session object
   */
  public function __construct(&$session) {
    $this->session = $session;
  }
  
  /**
   * Set an object into flash scope
   * 
   * @param String $name the name of the object to put into flash scope
   * @param mixed $value the value to put into flash
   */
  public function __set($name,$value) {
    $this->session->set("flash.$name",$value);
  }
  
  /**
   * Get an object from flash scope
   *
   * @param String $name the name of the value to retrieve from flash
   */
  public function __get($name) {
  	return $this->session->get($name);
  }
  
  
}

?>