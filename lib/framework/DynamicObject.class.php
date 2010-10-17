<?php
/**
 * Defines DynamicObject class, a class which is extended to allow dynamic properties
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */


/**
 * DynamicObject.class.php
 *
 * Provides dynamic properties to any object which extends it.
 * 
 * Example:
 * 
 * <code>
 *  // Set properties
 * $dynamic_object->prop1 = 'property';
 *  $dynamic_object->prop2 = 'property2';
 *  // or
 * $dynamic_object->properties = array( 'prop1' => 'property', 'prop2' => 'property2' );
 * 
 *  // Get properties
 * $property1 = $dynamic_object->prop1;
 *  // or
 * $properties = $dynamic_object->properties;
 * </code>
 * 
 */
abstract class DynamicObject extends Object {
  
  /**
   * @var Array contains the properties for the object
   */
  private $__properties = array();
  
  /**
   * Handle get property calls, check to see if we have what they want
   * properties will return all properties
   *
   * @param string $name
   * @return mixed
   */
  public function __get($name) {
    // Return properties
    if( $name == 'properties' ) {
      return $this->__properties;
    }
		// Return property
		if( isset($this->__properties[$name]) ) {
		  return $this->__properties[$name];
		}
    return false;
  }
	
  /**
   * Handle property set calls, properties will set all properties ( overwriting any existing )
   * 
   * @uses trigger_error Triggers an error when $value argument is not a string
   * @param string $name
   * @param string $value
   */
  public function __set($name,$value) {
	
    // Set all the properties
    if( $name == 'properties' ) {
      if( is_array($value) ) {
        $this->__properties = $value;
      } else {
        trigger_error('Illegal Argument, must specify hashed array to set properties on a DynamicObject.',E_WARNING);
      }
      return;
    }
		
    // Check to see if the property is set readonly
    if( isset( $this->readonly_properties ) && in_array() ) {
      trigger_error('Illegal Access, '.$name.' is a readonly property of '.get_class($this).' object.',E_WARNING);
  	  return;
    }
		
    // Finally, just set the value already
    $this->__properties[$name] = $value;
  }
}

?>