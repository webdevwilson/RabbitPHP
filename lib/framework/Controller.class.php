<?php
/**
 * Defines abstract base class Controller
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

// Include EZPDO Framework and configure
require_once(RABBITPHP_HOME.'/lib/ezpdo/libs/adodb/adodb.inc.php');

/**
 * Provides base class implementation of the controller
 * 
 * Controller class defines methods that are used by all controller objects.
 * 
 * @uses Session
 * @uses CookieCollection
 */
abstract class Controller extends Object {
	
	/**
	 * @var Array contains the request parameters
	 */
	protected $params;
	
	/**
	 * @var Flash the current flash object
	 */
	protected $flash;
	
	/**
	 * @var Session the current session object
	 */
	protected $session;
	
	/**
	 * @var CookieCollection object containing the cookies from the browser
	 */
	protected $cookies;
	
	/**
	 * Contains the $_SERVER array
	 */
	protected $server;
	
	/**
	 * @var epManager the ezpdo manager instance
	 */
	protected $manager;
	
	/**
	 * @var AdodbConnection database connection
	 */
	protected $database;
	
	/**
	 * @var Array contains the model arrays
	 */
	protected $model;

	/**
	 * @var Array contains the name of the current controller
	 */
	public $name;
	
	/**
	 * @var String contains the name of the current plugin
	 */
	public $plugin;
	
	/**
	 * @var String The current action
	 */
	public $action;
	
	/**
	 * @var String the view to render
	 */
	public $view;
	
	/**
	 * @var String the view directory to render from
	 */
	public $view_directory;
	
	/**
	 * @var String the layout to use
	 */
	public $layout;
	
	/**
	 * @var Array contains the seperate parts of the url
	 */
	public $url_components;
  
  /**
   * @var String contains the full url ( i.e. /admin/partner/delete/1 )
   */
  public $url;
  	
	/**
	 * @var String contains the request method
	 */
	public $method = false;
	
	/**
	 * @var Boolean is the request a post?
	 */
	public $post = false;
	
	/**
	 * @var Boolean is the request a get?
	 */
	public $get = false;

  /**
   * @var Array the uploaded files
   */
  public $files = false;
  
  /**
   * @var Array the applications settings
   */
  public $settings = false;
	
	/**
	 * @var Boolean is this an ajax request?
	 */
	public $xhr_request = false;
	
	/**
	 * @var mixed what is the ajax method? ( execute, update )
	 */
	public $xhr_method = false;
	
	/**
	 * @var Array array of method names that are accessible via AJAX
	 */
	public $remote_methods = false;
	
	/**
	 * @var Array array containing i18n messages
	 */
	public $i18n_resources = false;
	
  /**
	 * Initialize the controller with request and response
	 */
	public function initialize($name,$action,$url_components) {
		  
		// Set up values
	  $this->plugin = ResourceLoader::instance()->current_plugin;
    $this->name = $name;
    $this->action = $action;
    $this->view = $action;
    $this->view_directory = $name;
    $this->url_components = $url_components;
  	$this->url = $_SERVER['REQUEST_URI'];
  	$this->method = strtoupper($_SERVER['REQUEST_METHOD']);
  	$this->post = ( $this->method == 'POST' );
    $this->get = ( $this->method == 'GET' );
    $this->settings = Settings::instance();
    
    $this->xhr_request = ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' );
    $this->xhr_method = $_SERVER['HTTP_X_XHR_METHOD'] ? $_SERVER['HTTP_X_XHR_METHOD'] : false;
    
    // Set Cookie
    $this->cookies = new CookieCollection($_COOKIE);
    $this->server = $_SERVER;
    $this->session = Session::instance();
    $this->flash = new Flash( $this->session );
    $this->files = $_FILES;
    
    // get i18n messages
    $langs = $this->parse_accept_language($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $this->i18n_resources = ResourceLoader::instance()->get_internationalization_messages($langs);
    
    // Setup the params
    $PARAMS = array_merge($_GET,$_POST);
    unset( $PARAMS['url'] );
    $this->params = $PARAMS;
    
    // Remove magic quote effect
    if( get_magic_quotes_gpc() ) {
    	$this->params = stripslashes_deep($this->params);
    }
    
    // Setup the model
    $this->model = $this->params['model'];
    
    // Get singleton instance of ezpdo persistence manager
    $this->manager = DomainObjectManager::instance();
    $dbconfig = new DatabaseConfiguration();
    if( $dbconfig->connection_string ) {
    	$this->database = ADONewConnection($dbconfig->connection_string);
    }
    
    // Set the layout & template vars
    if( $this->xhr_request ) {
      $this->layout = false;
    } else {
    	if( ! isset($this->layout) ) {
    		$this->layout = RABBITPHP_DEFAULT_TEMPLATE;
    	}
    }
    $this->template = RABBITPHP_DEFAULT_TEMPLATE;
  }
	
	/**
	 * Empty method, override to intercept all requests to this controller before action is called
	 */
	public function before_action() {}
	
	/**
	 * Empty method, override to intercept all requests to this controller after action is called
	 */
	public function after_action() {}
	
	/**
	 * Handle calls to undefined methods, defines the render_view()
	 * 
	 * @param string $method The method name
	 * @param mixed $args The method arguments
	 */
	public function __call($method,$args) {
    
    // Handle dynamic render method calls, render_view()
    if( substr($method,0,6) == 'render' ) {
      $this->view = substr($method,7);
    	return;
    }
    
    Trace::error( "Method $method does not exist in Controller" );
    
  }
  
  protected function render_element($element) {
  	$this->view_directory = 'elements';
  	$this->view = $element;
  }
  
  /**
   * Handle dynamic properties for model objects
   * 
   * @param string $name The name of the property
   */
  public function __get($name) {
  	return $this->model[$name];
  }
  
  /**
   * Send a browser redirect
   *
   * @param mixed url the url to redirect to, can be one of http://www.google.com, /admin/auth/login, login
   * @param mixed arguments ... arguments to append to the url
   */
  protected function redirect($url) {
  	
  	// Add plugin in front of request without it
  	if( substr($url,0,1) != '/' && 
  	    substr($url,0,5) != 'http:' &&
  	    substr($url,0,6) != 'https:' ) {
  	  
  	  $slash = strpos( $url, '/' );
  	  if( $slash > 0 ) {
  	  	$controller = substr( $url, 0, $slash );
  	  	$action = substr( $url, $slash+1 );
  	  } else {
  	  	$controller = $this->name;
  	  	$action = $url;
  	  }
  	  
  	  $url = '/'.$controller.'/'.$action;
  	  if( $this->plugin ) {
  	  	$url = '/'.$this->plugin.$url;    	
  	  }
  		
  	}
  	
  	// Add arguments to the end of the array
  	$args = func_get_args();
  	array_shift( $args );
  	if( count( $args ) > 0 ) {
  		$url .= '/' . implode( '/', $args );
  	}
  	
  	
  	// Redirect with response
    header("Location: $url");
    exit();
  	
  }
  
  /**
   * Send mail using the given view and model
   *
   * @param string $view The view file to use
   * @param string $model The model to inject into the view
   */
  protected function send_mail($view,$model=array()) {
  	
  	$smarty = SmartyFactory::create();
  	
  	if( !is_array( $model ) ) {
  		$model = array( $model );
  	}
  	
  	foreach( $model AS $key => $value ) {
  		$smarty->assign($key,$value);
  	}
  	
  }
  
  protected function log_message($message) {
  	
  	Logger::instance()->log_message($message);
  	
  }
  
  /**
	 * Parse the accept language header
	 *
	 * @param String $accept_lang The header value
	 * @param Array array sorted by language preference most preferred first
	 */
	private function parse_accept_language($accept_lang) {
		
		// default no accept_lang to en
		if( !$accept_lang ) {
			return array( 'en' );
		}
		
		$langs = array();
		
		$langs_split = explode(',',$accept_lang);
		foreach( $langs_split AS $lang ) {
			
			$lang = trim( $lang );
			if( strpos( $lang, ';' ) > 0 ) {
				list( $language, $qval ) = split(';',$lang);
				list( $null, $value ) = split('=',$qval);
				$langs[$language] = floatval( $value );
			} else {
				$langs[$lang] = 1.0;
			}
			
		}
		
		arsort( $langs );
		
		return $langs;
		
	}
  
}

	/**
	 * Function strips slashes in an array recursively, should be moved somewhere else
	 *
	 * @param Array $value the array to strip slashes from
	 * @return Array array w/o slashes
	 */
	function stripslashes_deep($value)
	{
		$value = is_array($value) ?
	  	         array_map('stripslashes_deep', $value) :
	             stripslashes($value);
	
	  return $value;
	}

?>