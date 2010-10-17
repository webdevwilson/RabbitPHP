<?php
/**
 * This file defines the not_logged_in tag
 * @package RabbitPHP_Plugins_User
 * @subpackage Tags
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @license http://www.rabbitphp.org/LICENSE
 */
 
/**
 * not_logged_in tag executes the block if the user is not logged in
 */
function smarty_block_not_logged_in($params, $content, &$smarty, &$repeat)
{
		$session = Session::instance();
		if(! $repeat ) {
			if(! $session->is_set( 'user.user_id' ) ) {
        return $content;
      }
    }
}
?> 