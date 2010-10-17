<?php
/**
 * Defines JavascriptController Object
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
class JavascriptController extends Controller {
	
	public function remote() {
		
		
		$controllers = ResourceLoader::get_controllers();
		$js = '';
		
		foreach( $controllers AS $controller ) {
			
			$c = new $controller();
			
			if( $c->remote_methods && count( $c->remote_methods ) > 0 ) {
				
				$js .= "$controller = Class.create();\n";
				$js .= "$controller = {\n";
				
				foreach( $c->remote_methods AS $method ) {
					$js .= "\n\t$method: function() {\n";
					$js .= "\tif(typeof(arguments[0]) == 'function' ) {\n";
					$js .= "\t\tnew RemoteCall.execute('/'+RabbitPHP.module+'/'+arguments[0]);";
					$js .= "if(typeof(arguments[0]) == 'function' ) {\n";
					$js .= "if(typeof(arguments[0]) == 'function' ) {\n";
					$js .= "if(typeof(arguments[0]) == 'function' ) {\n";
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