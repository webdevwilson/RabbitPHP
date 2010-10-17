<?php
/**
 * This file defines the Validator class, a class which provides static methods for 
 * validating domain objects.
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Provides static methods used in validation of domain objects, these methods should generally
 * not be called directly.  An ezpdo-enabled domain object is passed to the static validate method
 * This class uses the constraints property of the domain object to perform data validation.
 * 
 * Domain object properties which are used:
 * constraints - an associative array containing all the validation rules for an object
 *               the array has the following format:  array( $property1 => array( 'rule1' => args, 'rule2' => args ),
 *                                                           $property2 => array( 'rule1' => args, 'rule2' => args ));
 * 
 * Custom validation can be implemented one of two ways:
 *
 * 1. Using the custom function passed (a)String name of function, or (b)array containing classname then string name of function to call
 * 2. If a rule does not exist in Validator the method is called back on the object
 *
 */
class Validator {
  
  /**
   * Default messages used when validation fails.
   * @var Array
   */
  private static $default_messages = array(
                            'default.default'    => '$property is invalid.',
                            'default.minimum'    => '$property must be more than $arg1',
                            'default.maximum'    => '$property must be less than $arg1',
                            'default.in_range'   => '$property must be between $arg1 and $arg2',
                            'default.in_list'    => '$property must be in one of $arg1',
                            'default.unique'     => '$property must be unique.',
                            'default.min_length' => '$property must be at least $arg1 characters long.',
                            'default.max_length' => '$property must shorter than $arg1 characters long.',
                            'default.email'      => '$property must be a valid email address.',
                            'default.required'   => '$property is a required field',
                            'default.matches'    => '$property is invalid (must match $arg1)',
                            'default.custom'     => '$property is invalid'
                            );
  
  /**
   * Static access to the current object being validated.
   * @var Object
   */
  public static $object;
  
  /**
   * Static access to property name of the current property being validated
   * @var String
   */
  public static $property;
  
  /**
   * Validates a domain object using it's constraints property
   *
   * @param DomainObject $object the domain object to validate
   * @return number of errors
   */
  public static function validate(&$object) {
    
    $constraints = $object->constraints;
    $validation_errors = 0;
    $messages = array();
    Validator::$object = &$object;
    
    foreach( $constraints as $property => $rules ) {
    	
    	// Set current property
    	Validator::$property = $property;
    	
    	// force scalar values into array
    	if( !is_array( $rules ) ) {
    	  $rules = array( $rules );
    	}
    	
    	foreach( $rules as $rule => $args ) {
    		
    		if( !is_array( $args ) ) { $args = array( $args ); }
    		
    		array_unshift( $args, $object->{$property} );
    		
    		$invalid = true;
    		if( method_exists( 'Validator', $rule ) ) {
    			$valid = call_user_func_array( array('Validator',$rule), $args);
    		} else {
    			$valid = call_user_func_array( array($object,$rule), $args);
    		}
    		
    	  if( ! $valid ) {
    	  	
    	  	$validation_errors++;
    	  	
    	  	// Put arguments into arg1 variables
    	  	$i=0;
    	  	foreach( $args as $arg ) { ${"arg$i"} = $arg; $i++;	}
    	  	
    	  	// Get the message
    	  	//$message = $object->default_messages['default.'.$rule];
    	  	$message = Validator::$default_messages['default.'.$rule];
    	  	
    	  	if( isset( $object->messages[$property.'.'.$rule] ) ) {
    	      $message = $object->messages[$property.'.'.$rule];
    	  	}
    	  	
    	  	$messages[$property][$rule] = eval( 'return "'.$message.'";' );
    	  	
    	  }
    	}
    }
    
    $object->validation_messages = array_merge( $object->validation_messages, $messages );
    
    // return the number of messages
    return ( $validation_errors == 0 );
  }

  /**
   * Validates that field's value is more than a certain amount
   *
   * @param mixed $value the value of the field
   * @param int $min - The minimum allowed
   * @return true if value is more than the minimum allowed
   */
  public static function minimum($value, $min) {
  	return ( $value >= $min );
  }
 
  /**
   * Validates that field's value is less than a certain amount
   *
   * @param mixed $value the value of the field
   * @param int $max - The maximum allowed
   * @return true if value is less than the max allowed
   */
  public static function maximum($value, $max) {
  	return ( $value <= $max );
  }
  
  /**
   * Validates that field's value is in a certain range
   *
   * @param mixed $value the value of the field
   * @param int $min - The minimum allowed
   * @param int $max - The maximum allowed
   * @return true if value is between the minimum and maximum
   */
  public static function in_range($value,$min,$max) {
  	return ( $min <= $value && $value <= $max );
  }
  
  /**
   * Validates a field with a custom validation routine
   *
   * Example Usage:
   * 
   * $constraints = array( 'name' => array( 'custom' => array( 'check_name', array('name1','name2') ) ) );
   *
   * Above example will call check_name function with value of the field as the first argument and
   * the names as the second.
   *
   * function check_name($value, $valid_names) { 
   *   return in_array( $value, $valid_names ); 
   * }
   *
   * first argument can be an array of type array( 'classname', 'function' ) to call static method of an object
   *
   * @param mixed $value the value of the field
   * @param mixed $function the function to call ( passed to call_user_func_array as first parameter )
   * @return function results, true if valid, false otherwise
   */
  public static function custom($value,$function) {
  	$args = array_slice( func_get_args(), 2 );
  	array_unshift( $args, $value );
  	return call_user_func_array( $function, $args );
  }
  
  /**
   * Validates that a field's value is in a list
   *
   * @param mixed $value the value of the field
   * @return true if value is in the list
   */
  public static function in_list($value) {
  	$list = array_slice( func_get_args(), 1 );
  	return in_array( $value, $list );
  }
  
  /**
   * Validates that a field contains a unique value, this method is not functioning
   * until find out how to compare objects 
   *
   * @param mixed $value the value of the field
   * @param boolean $unique whether the property is required to be unique or not
   * @return true if required property needs to be unique
   */
  public static function unique($value,$unique) {
  	
  	if( $unique ) {
  	  
  	  $ezoql = 'from '.get_class(Validator::$object).' where '.Validator::$property.' = ?';
      $objects = epManager::instance()->find($ezoql,$value);
      
      return ( count($objects) == 0 ||
               count($objects) == 1 && $objects[0]->oid == Validator::$object->id );
      
    }
    return true;
  }
  
  /**
   * Validates a value is an email address
   *
   * @param mixed $value the value of the field
   * @param boolean $required whether the property is required or not
   * @return true if required property is not empty
   */
  public static function email($value,$required=true) {
  	
  	// Always return true if empty ( don't want email to imply required. )
  	if( $value == '' ) { return true; }
  	
  	return Validator::matches($value,'/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.(com|org|net|biz|info|name|net|pro|aero|coop|museum|[a-z]{2,4}))$)\\z/i');
  }

  /**
   * Validates a value using regular expression pattern
   *
   * @param mixed $value the value of the field
   * @param string $regex The regular expression to match against
   * @return true if required property matches regular expression
   */
  public static function matches($value,$regex) {
  	
  	return ( preg_match( $regex, $value ) > 0 );
  }

  /**
   * Validates the existence of a required property
   *
   * @param mixed $value the value of the field
   * @param boolean $required whether the property is required or not
   * @return true if required property is not empty
   */
  public static function required($value,$required) {
    if (($value instanceof Countable) && $required )
        return (count($value) > 0);
    return ( 
            !$required || 
            !empty( $value )
    );    
  }

 
  /**
   * Validates the length of a property
   *
   * @param mixed $value the value of the field
   * @param int $length The maximum length
   * @return true if greater than minimum length ( valid )
   */
  public static function min_length($value,$length) {
  	return ( strlen($value) >= intval( $length ) );
  }
 
  /**
   * Validates the length of a property
   *
   * @param mixed $value the value of the field
   * @param int $length The maximum length
   * @return true if less than maximum length ( valid )
   */
  public static function max_length($value,$length) {
  	return ( strlen($value) <= intval( $length ) );
  }
  
  /**
   * Validates a credit card, using checksum method
   *
   * @param mixed $value the value of the field
   * @param int $required is it required to be a credit card
   * @return true if less than maximum length ( valid )
   */ 
  public static function credit_card($value,$required) {
  	
  	// So credit_card does not imply required
  	if( empty( $value ) ) { return true; }
  	
  	if( $required ) {
  		
      $checksum = 0;                                  // running checksum total
      $mychar = "";                                   // next char to process
      $j = 1;                                         // takes value of 1 or 2
  
      // Process each digit one by one starting at the right
      for ($i = strlen($value) - 1; $i >= 0; $i--) {
    
        // Extract the next digit and multiply by 1 or 2 on alternative digits.      
        $calc = $value{$i} * $j;
    
        // If the result is in two digits add 1 to the checksum total
        if ($calc > 9) {
          $checksum = $checksum + 1;
          $calc = $calc - 10;
        }
    
        // Add the units element to the checksum total
        $checksum = $checksum + $calc;
    
        // Switch the value of j
        if ($j ==1) {$j = 2;} else {$j = 1;};
      } 
      return ($checksum % 10 == 0);
  		
  	}
  	return true;
  	
  }
  

  
}
?>
