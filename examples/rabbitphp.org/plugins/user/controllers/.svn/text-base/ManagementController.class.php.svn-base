<?php
/**
 * This file defines the ManagementController class
 * @package RabbitPHP_Plugins_User
 * @subpackage Controllers
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * ManagementControler is the default controller for User management
 *
 * @see User
 */
class ManagementController extends AuthenticatedController {
	
	public function index() {
		
		$this->view = 'list';
		return array( 'users' => $this->manager->list_user() );
		
	}
	
	public function create() {
		
	}
	
	public function edit($id='') {
		$user = $this->manager->get_user($id);
		if(! $user ) {
			$this->redirect('index');	
		}
		
		var_dump( $this->manager->getClassMap('User') );
		
		$this->view = 'form';
		return array( 'user' => $user, 'roles' => $this->manager->list_role() );
	}
	
	public function save() {
		
	}
	
	public function delete() {
		
	}
	
}

?>