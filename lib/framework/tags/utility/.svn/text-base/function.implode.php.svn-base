<?php
/**
 * Defines the implode smarty tag, which outputs an imploded array, for creating comma separated displays, etc..
 *
 * <b>Parameters:</b><br />
 * pieces - The array to implode
 * glue - The characters between the elements
 *
 * @package RabbitPHP_Tags
 * @subpackage Utility
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */

function smarty_function_implode($params, &$smarty)
{	
    if(count($params['pieces']) > 0) {
        // convert arrays to string array
        $pieces = array();
        foreach( $params['pieces'] as $piece ) {
            $pieces[] = strval($piece);
        }
 			
     	return implode($params['glue'],$pieces);
    }

}
?>