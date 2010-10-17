<?php
/**
 * This file defines the BaseController class
 * @package RabbitPHP_Plugins_User
 * @subpackage Controllers
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * BaseController is the base for user controller
 *
 * @see AuthenticatedController
 * @see User
 */
class BaseController extends AuthenticatedController {
  
  protected function login(&$user) {
  	
  	// Add to session
  	$this->session->set(Globals::$SESSION_USERID_KEY,$user->oid);
  	
  	// Update last login time
  	$user->last_login = mktime();
  	$this->manager->commit($user);
  	
  }
  
  protected function logout() {
  	
  	// Remove userid from session
  	$this->session->remove(Globals::$SESSION_USERID_KEY);
  	
  }
  
  
}

?>