<?php
/**
 * Defines the ajaxlink smarty tag, which is used to populate a 
 *      block element with the results of a controller call
 * @package RabbitPHP_Tags
 * @subpackage Html
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_ajaxlink($params,&$smarty) {
    $class = !empty($params['class']) ? $params['class'] : 'ajaxlink';
    return "
    <a 
        class=\"$class\"
        style=\"{$params['style']}\" 
        onclick=\"RemoteCall.update($('{$params['target']}'), '{$params['remotemethoduri']}')\" 
    >{$params['content']}</a>
    ";
}

?>
