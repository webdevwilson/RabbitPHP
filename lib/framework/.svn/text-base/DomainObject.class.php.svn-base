<?php
/**
 * Defines DomainObject class, the base class for DomainObjects
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Provides validation and population methods for all domain objects
 * 
 * Methods:
 * 
 * populate($properties) - Pass an array to populate the properties
 * is_valid() - Validate the object using the constraints
 * 
 */
class DomainObject extends Object {
  
  public $constraints = array();
  
  public $validation_messages = array();
  
  public $id = false;
  
  private $valid = true;
  
  /**
   * Date partner was created
   * @var date
   * @orm datetime
   */
  public $created;
    
  /**
   * Date partner was last updated
   * @var date
   * @orm datetime
   */
  public $updated;
  
  // EZPDO EVENT METHOD STUBS
  
  /**
   * on_create method called when an object is created
   */
  public function on_create() {}
  
  /**
   * on_load method called when loading the object
   */
  public function on_load() {}
  
  /**
   * on_insert method is called before inserting the object
   */
  public function on_insert() {}
  
  /**
   * on_update method is called before updating the object
   */
  public function on_update() {}
  
  /**
   * on_delete method is called when deleting the object
   */
  public function on_delete() {}
  
  /**
   * Used to fill properties with an array where key is the property name
   * and value is what to fill is with
   *
   * @param Array $properties associative array containg the key - values to fill
   */
  public function populate($properties) {
    
    if( is_array( $properties ) ) {
      foreach( $properties AS $name => $value ) {
        $this->{$name} = $value;
      }
    }
    
  }
  
  /**
   * Determine whether or not this object is valid, fills validation_messages
   *
   * @return true if valid, false otherwise
   */
  public function is_valid() {
  	return ( Validator::validate($this) && $this->valid );
  }
  
  /**
   * Set a property as invalid
   *
   * @param String property The name of the property
   * @param String constraint The name of the constraint that was invalid
   */
  public function set_invalid( $property, $constraint ) {
  	$this->valid = false;
  	
  	// get message
  	if( isset( $this->messages[$property.'.'.$constraint] ) ) {
      $message = $this->messages[$property.'.'.$constraint];
  	} else {
  		$message = $constraint.' violated.';
  	}
  	
  	$this->validation_messages[$property][$constraint] = $message;
  	
  }
  
  /**
   * Determine whether a domain object or field is invalid, is_valid() must be run first for this
   * method to work properly
   *
   * @param String $field optional name of property, if not given returns whether object is invalid
   * @return True if field or object is invalid, false otherwise
   */
  public function invalid($field=false) {
  	if( $field ) {
  		return ( count( $this->validation_messages[$field] ) > 0 );
  	} else {
  		return ( count( $this->validation_messages ) > 0 );
  	}
  }
  
  /**
   * Domain object constructor
   * Adds domain object as listener to ezpdo
   */
  public function __construct($properties=array()) {
  	$this->populate( $properties );
  }
  
  /**
   * convert domain object to an array
   *
   * @param int $depth The depth to go in relationships ( default = 0 )
   */
  public function to_array($depth=0) {
  	
  	$array = array();
  	
  	foreach( $this AS $k => $o ) {
  	
  		// var scalar or null?
      if (!is_scalar($o) && !is_null($o)) {
      	if ($depth > 0) {
        	// if not, expand one level 
          $array[$k] = $o->to_array($depth-1);
        } else if ($o instanceof epObject) {
           // o.w. encode 
           $array[$k] = $o->epGetClass().':'.$o->epGetObjectId();
        }
        continue;
      }
            
      // collect the regular value
      $array[$k] = $o;
    }
    
    return $array;
  }
  
  /**
   * return the default string representation of the object
   * @return String class and id of the object (ie. BlogPost #10)
   */
  public function __toString() {
    return get_class($this) . ' #' . $this->id;
  }
}

?>