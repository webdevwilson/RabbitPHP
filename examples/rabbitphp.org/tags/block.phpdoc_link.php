<?php
/**
 * This file defines the phpdoc_link, used to link to documentation
 * @package RabbitPHP_Site
 * @subpackage Tags
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * Function that defines the phpdoc_link tag, accepts following parameters (all required):<br />
 * package - The package the class is in<br />
 * subpackage - The subpackage the class is in<br />
 * class - The class to link
 */
function smarty_block_phpdoc_link($params, $content, &$smarty, &$repeat)
{
    // only output on the closing tag
    if(!$repeat){
        if (isset($content)) {
            $htm = '<a href=\'/docs/'.$params['package'].'/'.$params['subpackage'].'/'.$params['class'].'.html';
            if( isset($params['method'] ) ) {
            	$htm .= '#'.$params['method'];
            }
            $htm .= '\' class=\'phpdoc_link\'>'.$content.'</a>';
            return $htm;
        }
    }
}