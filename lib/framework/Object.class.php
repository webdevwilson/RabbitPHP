<?php
/**
 * Defines Object
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
class Object {
  
  /**
   * __toString magic method called to convert object to string
   *
   * @return class name
   */
  public function __toString() {
    return get_class( $this );
  }
}

?>