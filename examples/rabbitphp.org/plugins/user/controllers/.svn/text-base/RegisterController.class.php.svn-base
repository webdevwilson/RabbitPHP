<?php
/**
 * This file defines the RegisterController class
 * @package RabbitPHP_Plugins_User
 * @subpackage Controllers
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * RegisterController handles user registration
 *
 * @see BaseController
 * @see User
 */
class RegisterController extends BaseController {
	
	public $remote_methods = array( 'validate_email' );
	public $no_authentication = array( 'index', 'new_user', 'process', 'validate_email' );
	
	/**
	 * index action redirects to new_user action
	 */
	public function index() {
		$this->redirect('new_user');
	}
	
	/**
	 * new_user action sets view to form and puts state options in request
	 */
	public function new_user() {
		
		$this->view = 'form';
		return array( 'states' => StateOptions::$abbreviated );
	}
	
	/**
	 * Process the registration, then redirect to view
	 */
	public function process() {
		
		if( $this->post ) {
			
			// create the user
			$user = $this->manager->create_user();
			
			// populate from request parameters
			$user->populate($this->model['user']);
			
			if( $user->is_valid() ) {
				
				if( $this->manager->commit($user) ) {
					$this->flash->message = 'You have successfully registered';
					$this->redirect('profile/view');	
				}
				
			} else {
				
				// Return them to prepopulated form
				$this->flash->warning = 'Please fill out all the required fields.';
				$this->view = 'form';
				return array( 'user' => $user );
			}
		}
	}
	
	/**
	 * Check the availability of an email address
	 *
	 * @param string email the email to validate
	 * @return validation results
	 */
	public function validate_email($email) {
		
		// Validate email
		$valid = false;
		if( Validator::email($email) ) {
			if( $this->manager->get_user_by_email_address( $email ) ) {
				$message = 'Email Address already in use.';
			} else {
				$valid = true;
			}
		} else {
			$message = 'Invalid Email Address.';
		}
		
		return array( 'valid' => $valid,
									'message' => $message,
									'email' => $email
								);
	}
	
}

?>