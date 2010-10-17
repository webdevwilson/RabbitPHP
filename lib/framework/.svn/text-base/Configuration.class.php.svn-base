<?php
/**
 * Defines the configuration class, a class that is used to hold configuration values,
 * protected properties are exposed as read-only properties
 *
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

/**
 * Configuration class exposes all protected property members as readonly entities
 */
class Configuration {
	
	public function __get($name) {
		
		if( isset( $this->{$name} ) ) {
			return $this->{$name};
		}
		
		return false;
	}
	
}

?>