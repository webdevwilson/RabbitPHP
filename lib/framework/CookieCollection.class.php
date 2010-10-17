<?php
/**
 * Defines CookieCollection object
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

/**
 * Represents a collection of cookies received from the browser.  Provides all the methods
 * necessary to manipulate cookies.
 * 
 * @uses setcookie
 */
class CookieCollection extends Object {

  private $cookies = array();
  
  /**
   * Construct an object with cookies array
   */
  public function __construct(array $cookies) {
  	$this->cookies = $cookies;
  }
  
  /**
   * Set a new cookie
   *
   * @param name The name of the cookie
   * @param value The value of the cookie
   * @param expire The expiration date of the cookie
   * @param path The path on the server in which the cookie will be available on. 
   * @param domain The domain that the cookie is available.
   * @param secure Indicates that the cookie should only be transmitted over a secure HTTPS connection.
   * @param http_only When TRUE the cookie will be made accessible only through the HTTP protocol.
   */
  public function set_cookie($name,$value,$expire=-1,$path='/',$domain='',$secure=false,$http_only=false) {
  	$this->cookies[$name] = $value;
    setcookie($name, $value, $expire, $path, $domain, $secure, $http_only);	
  }
  
  /**
   * Get all of the cookies
   *
   * @return array all of the cookies
   */
  public function get_cookie_map() {
    return $this->cookies;	
  }
  
  /**
   * Dynamic get property retrieves cookie value
   *
   * @param Name string the name of the cookie
   * @return the value of the cookie
   */
  public function __get($name) {
    return $this->cookies[$name];
  }
}

?>