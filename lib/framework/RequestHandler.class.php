<?php
/**
 * This file defines the RequestHandler class, it is the main entry point into the RabbitPHP framework.
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Provides static handle_request() method which is the main entry point into the RabbitPHP framework.
 * 
 * @uses Controller 
 */
class RequestHandler {
  
  /**
   * The main entry point method into the RABBITPHP framework, this method completes the following steps:
   * <ol>
   *   <li>Determine the controller and action</li>
   *   <li>Instantiate the controller and call the appropriate methods</li>
   * </ol>
   * 3. Assign implicit variables and controller properties to the response
   * 4. Get the view output and send it to the template
   * 
   * @param Request $request The current request object
   * @param Response $response The response object
   */
  public static function handle_request() {
    
    $app_config = new AppConfiguration();
    
    // Parse Request URI
    $url_components = explode('/',$_REQUEST['url']);
   
    // get controller name and action from request
    if( ResourceLoader::instance()->current_plugin ) {
    	list( $plugin, $controller_name, $action ) = $url_components;
    	$args = "'".implode('\',\'',array_slice( $url_components, 3 ))."'";
    } else {
    	list( $controller_name, $action ) = $url_components;
    	$args = "'".implode('\',\'',array_slice( $url_components, 2 ))."'";
    }
    
    // set to defaults if necessary
    if( !$action ) {
    	$action = RABBITPHP_DEFAULT_ACTION;
    }
    if( empty( $controller_name ) ) {
    	$controller_name = RABBITPHP_DEFAULT_CONTROLLER;
    }
		
    Trace::info( $controller_name );

    // Construct the controller
    $controller_class = str_replace(' ','',ucwords(str_replace('_',' ',$controller_name))).'Controller';
    $controller_class = ucwords($controller_class);
  	
    Trace::info("Instantiating $controller_class to handle request.");  	
   
    // Instantiate the controller
    $controller = new $controller_class;
    unset($controller_class);
    
    // Initialize the controller
    $controller->initialize($controller_name,$action,$url_components);
		
		// Check to see if remote invocation and if we have permission to
    if( $controller->xhr_request && ( 
        !$controller->remote_methods || !in_array( $controller->action, $controller->remote_methods ) ) ) {
      // Invalid AJAX Called  
    	header('HTTP/1.1 403 Forbidden');
    	echo 'Invalid Remote Action Called.';
    	die();
    }
    
    // Before interceptor
    $before_action_results = $controller->before_action();
		if( !is_array( $before_action_results ) ) {
			$before_action_results = array();
		}
		
    // Execute the action
    Trace::info("Calling $action method on controller.");
    
    $action = str_replace( '-', '', $action );
    $action_results = eval("return \$controller->$action($args);");
    
    if( !is_array( $action_results ) ) {
			$action_results = array('model' => $action_results);
		}
		
		// After interceptor
    $after_action_results = $controller->after_action();
		if( !is_array( $after_action_results ) ) {
			$after_action_results = array();
		}    
    
    // Handle javascript Remote.execute method calls
    if( $controller->xhr_request && $controller->xhr_method == 'execute' ) {
    	Trace::disable();
   		header('Content-Type: text/javascript');
   		header('X-JSON: '.HtmlBuilder::javascript_export($action_results));
   		return;
    }
    
    $model = array_merge( $before_action_results, $action_results, $after_action_results );
    
    // Assign all model values to smarty context
    $model = array();
    if( $model ) {
      if( !is_array($model) ) {
        $model = array( 'model' => $model );
      }
      foreach( $model AS $name => $var ) {
    	  $model[$name] = $var;
      }
    }
    
    $PARAMS = array_merge($_GET,$_POST);
    unset( $PARAMS['url'] );
    
    $model['controller'] = get_object_vars($controller);
    $model['params'] = $PARAMS;
    $model['session'] = Session::instance()->get_all();
    $model['cookies'] = $_COOKIE;
    $model['url_components'] = $url_components;
    $model['settings'] = Settings::instance()->get_all();
    $model['i18n'] = $controller->i18n_resources;
    
    // Get flash variables and remove from session
    $flash = array();
    $session_vars = Session::instance()->get_all();
    foreach( $session_vars as $key => $value ) {
    	
    	if( substr( $key, 0, 6 ) == 'flash.' ) {
    		$flash[substr($key,6)] = $value;
    		Session::instance()->remove( $key );
    	}
    }
    $model['flash'] = $flash;
    
    // create view resolver
    $view_resolver_class = $app_config->view_resolver.'ViewResolver';
    if( $controller->view_resolver ) {
        $view_resolver_class = $controller->view_resolver.'ViewResolver';
    }
    $view_resolver = new $view_resolver_class;
    $view_resolver->initialize($model);
    Trace::set_view_objects($model);

    // Fetch the view output
    $view = '';
    if( $controller->view ) {
        $view_name = $controller->view_directory.'/'.$controller->view;
        Trace::info('Dispatching to view file '.$view_name);
        $view = $view_resolver->render_view($view_name);
    }
    
    // Now send it to the template
    if( $controller->layout ) {
      $rendered_view = $view_resolver->render_layout( $controller->layout, $view );
    } else {
      Trace::info( 'No template detected, returning view only.' );
      $rendered_view = $view;
    }
    
    return $rendered_view;
  }

}

?>