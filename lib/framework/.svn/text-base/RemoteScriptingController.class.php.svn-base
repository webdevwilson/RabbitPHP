<?php
/**
 * Defines RemoteScriptingController Object
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 *
 * @todo implement this class, which will provide javascript variables for easy access 
 * to controller method calls in javascript
 */
 
class RemoteScriptingController extends Controller {
	
	public function controllers() {
		
		
		$controllers = ResourceLoader::get_controllers();
		$js = '';
		
		foreach( $controllers AS $controller ) {
			
			$c = new $controller();
			
			if( $c->remote_methods && count( $c->remote_methods ) > 0 ) {
				
				$js .= "$controller = Class.create();\n";
				$js .= "$controller = {\n";
				
				foreach( $c->remote_methods AS $method ) {
					$js .= "\n\t$method: function() {\n";
					$js .= "alert(this.arguments);";
					$js .= "new RemoteCall.execute();";
					$js .= "\n\t\t },";
				}
				
				$js = substr($js,0,-1)."\n}";
				
			}
			
		}
		echo $js;
		
		$this->view = false;
		$this->layout = false;
		
	}
	
}

?>