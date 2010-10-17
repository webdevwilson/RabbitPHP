<?php
/**
 * Defines the controller smarty tag, which lets the programmer embed controller calls in their controller tpls
 *
 * <b>Parameters:</b><br />
 * controller_name: the name of the controller the programmer is trying to call
 * controller_action: the action within the controller the programmer is trying to call
 * ... at this point the user can specify the action arguments
 *
 * @package RabbitPHP_Tags
 * @subpackage Utility
 * @author Matt Parker <moonmaster9000@gmail.com>
 * @version 0.1
 */

function smarty_function_controller($params, &$smarty_master)
{	
    if (!isset($params['controller_name']) || !isset($params['controller_action']))
        die('you must specify a controller_name and a controller_action');
    
    $original_controller_name = $params['controller_name'];
    $controller_plugin  = $params['controller_plugin'];
    $controller_name    = str_replace(' ', '', ucwords(str_replace('_', ' ', $params['controller_name']))) . 'Controller';
    $controller_action  = str_replace('-', '', $params['controller_action']);
    unset($params['controller_action']);
    unset($params['controller_name']);
    
    //see if we can find the method in the class or in the classes parent
    if (!empty($controller_plugin)){
        $current_plugin = ResourceLoader::instance()->current_plugin;
        ResourceLoader::instance()->current_plugin = $controller_plugin;
    }
    try{
        $reflection_action = new ReflectionMethod($controller_name, $controller_action);
    } catch(Exception $e) {
        if ($e->getMessage() == "Method {$controller_name}::{$controller_action}() does not exist"){
            die("Sorry, but we couldn't find the embedded controller action.\n (Reflection exception: " . $e->getMessage());
        }
        else 
            die('Unknown exception thrown when attempting to reverse engineer the controller you specified: ' . "\n" . $e->getMessage() );
    }
    $action_parameters  = $reflection_action->getParameters();
    $action_call        = "$controller_action(";
    $still_valid        = true;
    $url_components     = array();

    foreach ($action_parameters as $action_arg){
        if ($still_valid){
            //if the action requires an argument, but the programmer didn't specify it
            if (!$action_arg->isOptional() && !isset($params[$action_arg->getName()]))
                die("Sorry, but $controller_name::$controller_action() requires the argument {$action_arg->getName()}, "
                  . "but you didn't provide that argument when you embedded the controller in a smarty tag in your tpl.");
            else if (isset($params[$action_arg->getName()])){
                $url_components[] = (string)$params[$action_arg->getName()];
            }
            else if ($action_arg->isOptional()){
                //otherwise, we've reached the point where we no longer
                $still_valid = false;
            }
        }
    }
    
    $controller = new $controller_name;
    $controller->initialize($original_controller_name,$controller_action,$url_components);
    
    
    /***** EXECUTE THE ACTION SEQUENCE ******/
    // Before interceptor
    $before_action_results = $controller->before_action();
		if( !is_array( $before_action_results ) ) {
			$before_action_results = array();
		}
		
    $args = "'" . implode($url_components,"','") . "'";
    $action_results = eval("return \$controller->$controller_action($args);");
    
    if( !is_array( $action_results ) ) 
		$action_results = array('model' => $action_results);
	
	// After interceptor
    $after_action_results = $controller->after_action();
	if( !is_array( $after_action_results ) ) 
		$after_action_results = array();
	     
	$model = array_merge( $before_action_results, $action_results, $after_action_results );
    /***** END ACTION SEQUENCE ******/



    
    /****** DISPATCH ACTION RESULTS TO VIEW *****/
    $smarty = SmartyFactory::create();
		
    // Assign all model values to smarty context
    $smarty_context = array();
    if( $model ) {
      if( !is_array($model) ) {
        $model = array( 'model' => $model );
      }
      foreach( $model AS $name => $var ) {
    	  $smarty_context[$name] = $var;
      }
      unset($model);
    }
    
    // Assign implicit smarty var
    $PARAMS = array_merge($_GET,$_POST);
    //unset( $PARAMS['url'] );
    $smarty_context['controller'] = get_object_vars($controller);
    $smarty_context['params'] = $PARAMS;
    $smarty_context['session'] = Session::instance()->get_all();
    $smarty_context['cookies'] = $_COOKIE;
    $smarty_context['url_components'] = $url_components;
    $smarty_context['settings'] = Settings::instance()->get_all();
    $smarty_context['i18n'] = $controller->i18n_resources;

    // Get flash variables and remove from session
    /*
    $flash = array();
    $session_vars = Session::instance()->get_all();
    foreach( $session_vars AS $key => $value ) {
    	
    	if( substr( $key, 0, 6 ) == 'flash.' ) {
    		$flash[substr($key,6)] = $value;
    		Session::instance()->remove( $key );
    	}
    }
    $smarty_context['flash'] = $flash;
    */
    
    // Loop through and add values to smarty context
    foreach( $smarty_context AS $name => $value ) {
    	if( is_object( $value ) ) {
  	    $smarty->assign($name,$value);
  	  } else {
  	    $smarty->assign($name,$value);
      }
    }
    
    //Trace::set_view_objects($smarty_context);
    
    // Fetch the view output
    $view = '';

    if( $controller->view ) {
      $view = RequestHandler::dispatch_to_view($controller,$controller->view,$smarty);
      $smarty->assign('view',$view);
    }
    
    if (!empty($controller_plugin))
        ResourceLoader::instance()->current_plugin = $current_plugin;

    return $view; 
}

?>
