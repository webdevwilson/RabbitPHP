<?php
/**
 * This file defines the LogoutController class
 * @package RabbitPHP_Plugins_User
 * @subpackage Controllers
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * LogoutController handles user logging out
 *
 * @see BaseController
 * @see User
 */
class LogoutController extends BaseController {
	
	public $no_authentication = array( 'index' );
	
	public function index() {
		$this->logout();
		$this->redirect('login/');
	}
	
}

?>