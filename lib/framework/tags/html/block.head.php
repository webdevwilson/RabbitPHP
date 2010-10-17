<?php
/**
 * Defines the head smarty tag, which is used to add stuff to the head of the html<br />
 * Example Usage:<br />
 * {head}
 *   <base href='http://www.rabbitphp.org' />
 * {/head}
 * @package RabbitPHP_Tags
 * @subpackage Html
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_block_head( $params, $content, &$smarty, &$repeat ) {
  
 $smarty->_tpl_vars['rabbitphp_smartytags_head_content'] .= $content;
  
}

?>