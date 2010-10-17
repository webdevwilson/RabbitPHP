<?php
/**
 * Defines Logger Object
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
class Logger {

  private $messages;
  private $path;
  private $file;
  
  private static $instance;
  
  private function __construct() {
    $this->path = APP_BASE.'/logs/rabbitphp';
    $this->file = fopen( $this->path.'/'.date("m-d-Y").".log", 'a+' );
  }

  public static function instance() {
  
    if( !Logger::$instance ) {
      Logger::$instance = new Logger();
    }
    
    return Logger::$instance;
    
  }
  
  public function log_message($message) {
    fwrite($this->file,$message."\n");
  }
  
  public function queue_message($message) {
    $this->messages[] = $message;
  }
  
  public function process_queue() {
  	
  	if( is_array( $this->messages ) ) {
  	  $messages = array_reverse($this->messages);
  	  $this->messages = array();
  	
  	  foreach( $messages AS $msg ) {
  	    fwrite($this->file,$msg."\n");
  	  }
    }
  }

}

?>