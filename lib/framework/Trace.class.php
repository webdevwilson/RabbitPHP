<?php
/**
 * Defines Trace Object
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Trace class
 *
 * The trace class provides a clean method of debugging the application and provides convenience methods
 */
class Trace extends Object {

  private static $enabled = false;
  private static $messages = array();
  private static $queries = array();
  private static $performance_properties = array();
  private static $parse_time = 0;
  private static $view_objects;
  
  public static $ERROR = 'ERROR';
  public static $WARNING = 'WARNING';
  public static $INFO = 'INFO';
  
  
  /**
   * Log an error message
   *
   * @param string $msg The message to log as an error
   */
  public static function error($msg) {
  	if( Trace::$enabled ) {
      Trace::$messages[] = Trace::create_message($msg,Trace::$ERROR);
    }
  }
  
  /**
   * Log a warning message
   *
   * @param string $msg The message to log as a warning
   */
  public static function warning($msg) {
  	if( Trace::$enabled ) {
  	  Trace::$messages[] = Trace::create_message($msg,Trace::$WARNING);
    }
  }
  
  /**
   * Log an informational message
   *
   * @param string $msg The message to log as informational
   */
  public static function info($msg) {
  	if( Trace::$enabled ) {
  	  Trace::$messages[] = Trace::create_message($msg,Trace::$INFO);
  	}
  }
  
  /**
   * Add a query that was executed
   *
   * @param string sql the query that was executed
   * @param mixed results the results of the query
   */
  public static function add_query($type,$sql,$results) {
  	
  	if( Trace::$enabled ) {
  	
  	  $query = array();
  	  $query['time'] = microtime(true);
      $query['type'] = $type;
      $query['sql'] = $sql;
      $query['backtrace'] = array_reverse(array_slice( debug_backtrace(), 1 ));
    
      if( $type == 'SCALAR' ) {
    	  
    	  $query['result_columns'] = array( 'results' );
    	  $query['results'] = array( array( 'results' => $results ) );
    	
    	} else if ( $type == 'UPDATE' ) {
    	  
    	  $query['result_columns'] = array( 'affected rows' );
    	  $query['results'] = array( array( 'affected rows' => $results ) );
    	  
      } else if ( $type == 'QUERY' ) {
    	  
    	  // Read all results from result set
    	  $query['results'] = array();
    	  
    	  while ( $row = mysql_fetch_array($results) ) {
          
          // Initialize columns
          if( !isset( $query['result_columns'] ) ) {
          	foreach( $row AS $column => $value ) {
          		$query['result_columns'][] = $column;
          	}
          }
          
          $query['results'][] = $row;
        }
        
        // Rewind resultset
        @mysql_data_seek($results,0);
        
      } else if( $type == 'ERROR' ) {
    	  
    	  $query['result_columns'] = array( 'error' );
    	  $query['results'] = array( array( 'error' => $results ) );
    	
    	}
    
      
      Trace::$queries[] = $query;
    }
  }
  
  /**
   * Set the page parse time
   *
   * @param int page parse time
   */
  public static function set_parse_time($parse_time) {
  	Trace::$parse_time=$parse_time;
  }
  
  /**
   * Enable trace mechanism
   */
  public static function enable() {
    Trace::$enabled = true;
  }
  
  /**
   * Is trace enabled?
   *
   * @return True if enabled, false otherwise
   */
  public static function is_enabled() {
  	return Trace::$enabled;
  }
  
  /**
   * Disable trace mechanism
   */
  public static function disable() {
  	Trace::$enabled = false;
  }
  
  /**
   * Set the view objects
   *
   * @param view_object - The view objects
   */
  public static function set_view_objects($view_objects) {
    Trace::$view_objects = $view_objects;
  }
  
  /**
   * Set the session object
   *
   * @param request - The request object
   */
  public static function set_session(Session &$session) {
    Trace::$session = &$session;
  } 
  
  /**
   * Get the trace output
   *
   * @return html formatted text output
   */
  public static function get_output() {
    
    if( Trace::$enabled ) {
    
      $smarty = new Smarty();
      $smarty->debugging = true;
      $smarty->compile_dir  = SMARTY_COMPILE_DIR;
    
      $smarty->assign_by_ref('messages',Trace::$messages);
      $smarty->assign_by_ref('queries',Trace::$queries);
      $smarty->assign_by_ref('view_objects',Trace::$view_objects);
      $smarty->assign('session',$_SESSION);
      $smarty->assign_by_ref('cookie',Trace::$view_objects['cookie']);
      $smarty->assign('included_files',get_included_files());
      $smarty->assign('parse_time',Trace::$parse_time);
      
  	  return $smarty->fetch('file:'.RABBITPHP_HOME.'/lib/framework/Trace.view.tpl');
    }
    return '';
  }
 
  
  private static function create_message($msg,$level) {
    $message = array();
    $message['time'] = microtime(true);
    $message['text'] = $msg;
    $message['backtrace'] = array_reverse(array_slice( debug_backtrace(), 1 ));
    $message['level'] = $level;
    return $message;
  }
}

?>