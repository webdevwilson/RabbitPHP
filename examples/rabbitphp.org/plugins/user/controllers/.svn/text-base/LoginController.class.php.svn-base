<?php
/**
 * This file defines the LoginController class
 * @package RabbitPHP_Plugins_User
 * @subpackage Controllers
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * LoginController handles user logging in and out
 *
 * @see BaseController
 * @see User
 */
class LoginController extends BaseController {
  
  public $no_authentication = array( 'index', 'process', 'forgot_password', 'change_password' );
  
	public function index() {
    
    if( $this->session->is_set( Globals::$SESSION_USERID_KEY ) ) {
    	$this->redirect('profile');
    }
    
    $this->view = 'form';
      

  }
  
  public function process() {
  	
    if( $this->post ) {
    	
    	$user = $this->manager->get_user_by_email_address_and_password($this->model['user']['email_address'],md5($this->params['password']));
    	
    	if( $user ) {
    		
    		// login successful
    		$this->login( $user );
    		
    		if( $this->session->is_set(Globals::$SESSION_REDIRECT_URL) ) {
    			$this->redirect($this->session->get(Globals::$SESSION_REDIRECT_URL));
    		} else {
    		  $this->redirect('profile/index');
    		}
    	
    	} else {
    		
    		// login failed
    		$this->flash->warning = 'Login failed.';
    		$this->redirect('/user/login');
    	
    	}
    }
  }
  
  public function forgot_password() {
  	
  	if( $this->post ) {
  		
  		$user = $this->manager->get_user_by_email_address($this->model['user']['email_address']);
  		
  		if( $user ) {
  			
  			// delete all the password change tokens assigned to the user
  			$this->manager->delete_password_change_token_by_user($user);
  			
  			// Create password token
  			$password_token = $this->manager->create_password_change_token();
  			$password_token->user = $user;
  			$this->manager->commit( $password_token );
  			
  			$this->flash->message = 'A password change notification has been sent to \''.$this->model['user']['email_address'].'\'';
  			//$this->redirect('login');
  			
  		} else {
  			
  			$this->flash->warning = 'No user with email address \''.$this->model['user']['email_address'].'\' exists in the system.';
  			
  		}
  		
  	}
  	
  }
  
}

?>