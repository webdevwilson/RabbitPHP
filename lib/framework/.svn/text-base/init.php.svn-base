<?php
/**
 * Control script for RabbitPHP framework
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
ob_start();

// Set HTTP Status to 200
header('HTTP/1.1 200 OK');
date_default_timezone_set('America/New_York');

// Get page start
$parse_start = microtime();

// RabbitPHP defaults
define('RABBITPHP_DEFAULT_CONTROLLER', 'root' );
define('RABBITPHP_DEFAULT_ACTION', 'index' );
define('RABBITPHP_DEFAULT_TEMPLATE', 'default');

// include resource loader
require_once(RABBITPHP_HOME.'/lib/framework/ResourceLoader.class.php');

// Class loading function
function __autoload($classname) {
  
  $loader = ResourceLoader::instance();
  
  // Check for controller classes
  if( substr($classname,-10) == 'Controller' && $classname != 'Controller' ) {
  	if( $loader->load_controller_class($classname) ) {
  		return;
  	}
  }

  // Check for configuration classes
  if( substr($classname,-13) == 'Configuration' && $classname != 'Configuration' ) {
  	if( $loader->load_configuration_class($classname) ) {
  		return;
  	}
  }
  
  // Load utility classes
  if( $loader->load_utility_class($classname) ) {
  	return;
  }
  	
	// Check ezpdo autoload for the rest ( domain classes )
  if( class_exists('epManager',false) ) {
    if( epManager::instance()->autoload($classname) ) {
      return;
    }
  }

}

// Error handling function - Will be implemented in the future, not now
function handle_error( $errno, $errstr, $errfile, $errline, $errcontext ) {
	$errortype = array (  E_ERROR => 'Error', E_WARNING => 'Warning', E_PARSE => 'Parsing Error',
                        E_NOTICE => 'Notice', E_CORE_ERROR => 'Core Error', E_CORE_WARNING => 'Core Warning',
                        E_COMPILE_ERROR => 'Compile Error', E_COMPILE_WARNING => 'Compile Warning', E_USER_ERROR => 'User Error',
                        E_USER_WARNING => 'User Warning', E_USER_NOTICE => 'User Notice', E_STRICT => 'Runtime Notice', E_RECOVERABLE_ERROR  => 'Catchable Fatal Error' );
	if( $errno == E_NOTICE ) return;
	//Trace::error('['.$errortype[$errno].']&nbsp;'.$errstr);
}
//set_error_handler( 'handle_error' );

// Include Smarty Templating engine
define('SMARTY_DIR', RABBITPHP_HOME.'/lib/smarty/libs/');
require_once(SMARTY_DIR.'Smarty.class.php');
define('SMARTY_TEMPLATE_DIR', APP_BASE.'/view/layouts');
define('SMARTY_COMPILE_DIR', APP_BASE.'/cache/');

// Turn on trace
if( isset($_REQUEST['show_trace']) || ENVIRONMENT == 'DEVELOPMENT' ) {
	Trace::enable();
} else {
	Trace::disable();
}

error_reporting(E_ALL ^ E_NOTICE);

$output = RequestHandler::handle_request();

if( Trace::is_enabled() ) {
	Trace::set_parse_time( microtime() - $parse_start );
	$output = str_replace('</body>',Trace::get_output()."\r\n</body>",$output);
}

echo $output;

Logger::instance()->process_queue();

ob_end_flush();

?>
