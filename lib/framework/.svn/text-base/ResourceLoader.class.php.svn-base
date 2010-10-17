<?php
/**
 * Defines ResourceLoader Object, which handles class loading, view file locating, element file locations, etc...
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Provides static classes for retrieving resources such as classes and views
 */
class ResourceLoader {
  
  private static $instance;
  
  public $current_plugin = false;
  public $plugins;
  
  private function __construct() {
  	
  	// get the plugins
  	$this->plugins = array();
  	if ( $dh = opendir( APP_BASE.'/plugins' ) ) {
  		while ( ( $file = readdir($dh) ) !== false ) {
      	if( $file != '.' && $file != '..' ) {
      		$this->plugins[] = $file;
      	}
      }
      closedir($dh);
    }
    
    // set current_plugin
  	$uri = explode( '/', $_REQUEST['url'] );
  	if( in_array( $uri[0], $this->plugins ) ) {
  		$this->current_plugin = $uri[0];
  	}
  }
  
  /**
   * Singleton pattern implementation
   *
   * @return ResourceLoader the only instance of ResourceLoader
   */
  public static function instance() {
  	
  	if( !ResourceLoader::$instance ) {
  		ResourceLoader::$instance = new ResourceLoader();	
  	}
		
		return ResourceLoader::$instance;
	}  
  
  /**
   * Load a configuration class
   *
   * @param string classname Name of class to load
   * @return boolean true if loaded, false otherwise
   */
  public function load_configuration_class($classname) {
  	
    // Attempt to find it in app path
    if( file_exists( APP_BASE.'/config/'.$classname.'.class.php' ) ) {
      require_once( APP_BASE.'/config/'.$classname.'.class.php' );
      return true;
    }
    
    // Attempt to load controller from plugin path
    if( file_exists( APP_BASE.'/plugins/'.$this->current_plugin.'/config/'.$classname.'.class.php' ) ) {
      require_once(  APP_BASE.'/plugins/'.$this->current_plugin.'/config/'.$classname.'.class.php' );
      return true;
    }

  }
  
  /**
   * Load a controller class
   *
   * @param string classname Name of class to load
   * @return boolean true if loaded, false otherwise
   */
  public function load_controller_class($classname) {
  	
    // Attempt to find it in app path
    if( file_exists( APP_BASE.'/controllers/'.$classname.'.class.php' ) ) {
      require_once( APP_BASE.'/controllers/'.$classname.'.class.php' );
      return true;
    }
    
    // Attempt to load controller from plugin path
    if( file_exists( APP_BASE.'/plugins/'.$this->current_plugin.'/controllers/'.$classname.'.class.php' ) ) {
      require_once(  APP_BASE.'/plugins/'.$this->current_plugin.'/controllers/'.$classname.'.class.php' );
      return true;
    }

    // Load dynamic controller class, for controllers not found
    $smarty = SmartyFactory::create();
    $smarty->assign('controller_name',$classname);
    $class_php = $smarty->fetch('file:'.RABBITPHP_HOME.'/lib/framework/DynamicController.class.tpl');
    eval( $class_php );
  	
  	return true;
  }
  
  /**
   * Loads a utility class, checks framework, app classes, then plugin classes
   * 
   * @param string classname Name of class to load
   * @return boolean true if loaded, false otherwise
   */
  public function load_utility_class($classname) {
  	
  	// Check framework
  	if( file_exists( RABBITPHP_HOME.'/lib/framework/'.$classname.'.class.php' ) ) {
      require_once( RABBITPHP_HOME.'/lib/framework/'.$classname.'.class.php' );
      return true;
    }
    
    // Check app path
    if( file_exists( APP_BASE.'/classes/'.$classname.'.class.php' ) ) {
      require_once( APP_BASE.'/classes/'.$classname.'.class.php' );
      return true;
	  }
	  
	  // Check plugin paths
	  foreach( $this->plugins AS $plugin ) {
	  	if( file_exists( APP_BASE.'/plugins/'.$plugin.'/classes/'.$classname.'.class.php' ) ) {
      	require_once(  APP_BASE.'/plugins/'.$plugin.'/classes/'.$classname.'.class.php' );
      	return true;
    	}
	  }
	  
	  return false;
  }
  
  /**
   * Get the smarty plugin directories
   *
   * @return return array directories smarty will load plugins from
   */
  public function get_smarty_plugin_directories() {
  	
  	$plugin_dirs = array( RABBITPHP_HOME.'/lib/smarty/libs/plugins/',
                          RABBITPHP_HOME.'/lib/framework/tags/utility/',
                          RABBITPHP_HOME.'/lib/framework/tags/html/',
                          APP_BASE.'/tags/');
    
    foreach( $this->plugins AS $plugin ) {
    	$plugin_dirs[] = APP_BASE.'/plugins/'.$plugin.'/tags/';	
    }
    
    return $plugin_dirs;
    
  }
  
  /**
   * Get the path to a mail view file,
   * returns file path if just plain text email
   * returns array with 'html' & 'text' keys for multipart
   *
   * @param String view ( ex: account_activation )
   * @return Array text => text_file, html => html_file
   * @todo make check plugin path for mail files
   */
  public function get_mail_view_files($view) {
  	
  	// check for plain jane text only ( most common method )
  	if( file_exists(APP_BASE.'/mail/'.$view.'.tpl') ) {
    	
    	return APP_BASE.'/mail/'.$view.'.tpl';
    
    } else {
    	
    	$returner = array( 'text' => false, 'html' => false );
    	
    	// check for text body
    	if( file_exists(APP_BASE.'/mail/'.$view.'.text.tpl') ) {
    		$returner['text'] = APP_BASE.'/mail/'.$view.'.text.tpl'; 
    	}
    	
    	// check for html body
    	if( file_exists(APP_BASE.'/mail/'.$view.'.html.tpl') ) {
    		$returner['html'] = APP_BASE.'/mail/'.$view.'.html.tpl'; 
    	}
    	
    	return $returner;
    	
    }
    
    return false;
  	
  }
  
  /**
   * Get path to a view file
   *
   * @param String view ( ex: controller/index, form/process )
   */
  public function get_view_file($view) {
    
    // Search in module path
    if( file_exists(APP_BASE.'/view/'.$view.'.tpl') ) {
    	return APP_BASE.'/view/'.$view.'.tpl';
    }
    
    // Search in plugins path
    if( file_exists(APP_BASE.'/plugins/'.$this->current_plugin.'/view/'.$view.'.tpl') ) {
    	return APP_BASE.'/plugins/'.$this->current_plugin.'/view/'.$view.'.tpl';
    }
    
    return false;
  }
  
  /**
   * Get path to layout file
   *
   * @param String layout
   */
  public function get_layout_file($layout) {
  	
  	// Check to see if module layout exists
  	if( file_exists( APP_BASE.'/view/layouts/'.$layout.'.tpl' ) ) {
  		return APP_BASE.'/view/layouts/'.$layout.'.tpl';
  	}
  	
  	// Check to see if plugin layout exists
  	if( file_exists( APP_BASE.'/plugins/'.$this->current_plugin.'/view/layouts/'.$layout.'.tpl' ) ) {
  		return APP_BASE.'/plugins/'.$this->current_plugin.'/view/layouts/'.$layout.'.tpl';
  	}
  	
  	// Check to see if global layout exists
  	if( file_exists( APP_BASE.'/view/layouts/'.$layout.'.tpl' ) ) {
  		return APP_BASE.'/view/layouts/'.$layout.'.tpl';
  	}
  	
  	return false;
  }
  
  /**
   * Get the path to an element file
   *
   * @param String element name
   */
  public function get_element_file($element) {
  	
  	// Search in module path
    if( file_exists(APP_BASE.'/view/elements/'.$element.'.tpl') ) {
    	return APP_BASE.'/view/elements/'.$element.'.tpl';
    }
    
    // Search in global app path
    if( file_exists(APP_BASE.'/view/elements/'.$element.'.tpl') ) {
    	return APP_BASE.'/view/elements/'.$element.'.tpl';
    }
    
    // Search in framework
    if( file_exists(RABBITPHP_HOME.'/lib/framework/elements/'.$element.'.tpl') ) {
    	return RABBITPHP_HOME.'/lib/framework/elements/'.$element.'.tpl';
    }
    
    // Search in plugin directories
    foreach( $this->plugins AS $plugin ) {
    	if( file_exists(APP_BASE.'/plugins/'.$plugin.'/view/elements/'.$element.'.tpl') ) {
    		return APP_BASE.'/plugins/'.$plugin.'/view/elements/'.$element.'.tpl';
    	}
    }
    
  	return false;
  }
  
  /**
   * Load the i18n internationalization messages
   *
   * @param Array langs The languages accepted array( 'en-us' => 1.0, 'en' => .5 )
   * @todo check plugin path for i18n files
   */
  public function get_internationalization_messages($langs) {
  	
  	$resources = array();
  	
  	foreach( $langs AS $lang => $qval ) {
  		
  		$file = APP_BASE.'/i18n/'.$lang.'.ini';
  		$resources = array_merge( @parse_ini_file( $file ), $resources  );
  		
  		// check to see if we have regional dialect, but not main ( ie. en-us but not en )
  		// if this is the case, parse major dialect also
  		if( strpos( $lang, '-' ) > 0 ) {
  			$major = substr( $lang, 0, strpos( $lang, '-' ) );
  			if( !isset( $langs[$major] ) ) {
  				$file = APP_BASE.'/i18n/'.$major.'.ini';
  				$resources = array_merge( @parse_ini_file( $file ), $resources  );
  			}
  		}
  		
  	}
  	
  	return $resources;
  	
  }
  
  /**
   * Get the classes on the classpath ( not domain classes, or controllers )
   * @return Array array of classnames
   */
  public function get_classes() {
  	throw new Exception("ResourceLoader::get_classes() method not implemented");
  }
  
  /**
   * Get domain classes in the classpath
   * @return Array array of domain classnames
   */
  public function get_domain_classes() {
  	throw new Exception("ResourceLoader::get_domain_classes() method not implemented");
  }
  
}

?>