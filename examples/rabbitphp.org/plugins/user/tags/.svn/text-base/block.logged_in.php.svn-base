<?php
/**
 * This file defines the logged_in tag
 * @package RabbitPHP_Plugins_User
 * @subpackage Tags
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * logged_in tag executes the block if the user is logged in
 *
 * @todo add role functionality which will only execute if logged in and in a certain role
 */
function smarty_block_logged_in($params, $content, &$smarty, &$repeat)
{
		$session = Session::instance();
		if(! $repeat ) {
			if( $session->is_set( 'user.user_id' ) ) {
        return $content;
      }
    }
}
?> 