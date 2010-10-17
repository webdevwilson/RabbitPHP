<?php
/**
 * Defines Session Object
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Session object
 *
 * Convenient wrapper object around the session mechanism
 *
 * @todo Implement database persisted session management
 */
class Session extends Object {
  
  private static $instance;
  
  private function __construct() {
  	
  	// Start a session if necessary
  	if( session_id() === '' ) {
  	  session_start();
  	}
  	
  }
  
  /**
   * Retrieve an instance of the session object
   */
  public static function instance() {
  	if( ! Session::$instance ) {
  		Session::$instance = new Session;
  	}
  	
  	return Session::$instance;
  }
  
  /**
   * Determine if a value is set in session
   * 
   * @param string name of the attribute
   * @return boolean true if set, false otherwise
   */
  public function is_set($name) {
  	return isset( $_SESSION[$name] );
  }
  
  /**
   * Get reference to attribute
   *
   * @param string name of the attribute
   * @return mixed
   */
  public function &get_by_ref($name) {
  	return $_SESSION[$name];
  }
  
  /**
   * Get session attribute
   *
   * @param string name of the attribute
   * @return mixed
   */
  public function get($name) {
  	return $_SESSION[$name];
  }
  
  /**
   * Get all the session variables
   *
   * @return array of session variables
   */
  public function get_all() {
  	return $_SESSION;
  } 
  
  /**
   * Set an attribute by reference
   *
   * @param string name the name for the attribute
   * @param mixed value the value to bind
   */
  public function set_by_ref($name,&$value) {
  	$_SESSION[$name] = &$value;
  }
  
  /**
   * Set a session attribute
   *
   * @param string name the name for the attribute
   * @param mixed value the value to bind
   */
  public function set($name,$value) {
  	$_SESSION[$name] = $value;
  }
  
  /**
   * Remove a value from the session
   *
   * @param string name the name of the attribute to remove
   */
  public function remove($name) {
  	unset($_SESSION[$name]);
  }
  
  /**
   * Destroy the current session
   */
  public function destroy() {
  	session_destroy();
  }
  
  /**
   * Get all attributes
   *
   * @return Array of attributes
   */
  public function &get_map() {
  	return $_SESSION;
  }
  
  /**
   * Magic method __get allows for property access to session variables ( i.e. $user = $session->user )
   *
   * @param $name the name of the property to retrieve
   * @return session value
   */
  public function __get($name) {
  	return $this->get($name);
  }
  
  /**
   * Magic Method __set allows for property type access to session variables ( i.e. $session->user = $user )
   *
   * @param $name the name of the property to retrieve
   * @param $value the value of the property
   */
  public function __set($name,$value) {
  	$this->set($name,$value);
  }
}

?>