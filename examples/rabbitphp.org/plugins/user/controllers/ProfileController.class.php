<?php
/**
 * This file defines the ProfileController class
 * @package RabbitPHP_Plugins_User
 * @subpackage Controllers
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * ProfileController handles profile updates and views
 *
 * @see AuthenticatedController
 * @see User
 */
class ProfileController extends AuthenticatedController {
    
  public $no_authentication = array( 'change_password' );
    
  /**
   * redirect to view action
   */
  public function index() {
    $this->redirect('view');
  }
  
  /**
   * view the current profile
   */
  public function view() {
  	return array( 'user' => $this->user );
  }
  
  /**
   * process profile update
   */
  public function update() {
    
  }
  
  /**
   * change_password action receives an optional token, if no user logged in it will attempt to pull from token
   */
  public function change_password($token='') {
  	
  	$password_token = false;
  	
  	// if user not logged in, pull user from token
  	if(! $this->user ) {
  		
  		// Get the token
  		$password_token = $this->manager->get_password_change_token_by_token($token);
  	
  		// Determine the expiration date
  		$expiry_date = mktime() + ( 60 * 60 * 24 );
  		
  		if( $password_token && $password_token->created < $expiry_date ) {
  		
  			// Valid token
  			$this->user = $password_token->user;
  		
  		} else {
  			
  			// Delete expired passwords
  			if( $password_token->created >= $expiry_date ) {
  				$this->manager->delete_password_change_token_by_token($token);
  			}
  			
  			$this->flash->warning = 'Invalid token or token expired, please retry.';
  			$this->redirect('login/forgot_password');
  		}
  	}
  	
  	// On post update password
  	if( $this->post ) {
  		
  		// Insure old password matches user password
  		if( $this->user->password != md5($this->params['current_password']) ) {
  			$this->flash->warning = 'Current password incorrect.';
  			return;
  		}
  		
  		// Insure confirmation matched password
  		if( $this->params['new_password'] != $this->params['confirm_password'] ) {
  			$this->flash->warning = 'Confirm password must match new password.';
  			return;
  		}
  		
  		// Insure password is at least 6 characters long
  		if( strlen( $this->params['new_password'] ) < 6 ) {
  			$this->flash->warning = 'Password must be at least 6 characters long.';
  			return;
  		}
  		
  		// encrypt password, and save
  		$this->user->password = md5($this->params['new_password']);
  		if( $this->manager->commit($this->user) ) {
  			
  			$this->flash->message = 'Password updated.';
  			
  			// if password token was used, delete it
  			if( $password_token ) {
  				$this->manager->delete( $password_token );
  				$this->redirect('/user/login');
  			} else {
  				$this->redirect('/user/profile');
  			}
  		}
  	}
  }
}

?>