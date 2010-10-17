<?php
/**
 * Defines the link smarty tag, which will build a link using HtmlBuilder
 * @package RabbitPHP_Tags
 * @subpackage Html
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @see HtmlBuilder
 */
function smarty_block_link( $params, $content, &$smarty, &$repeat ) {
  
  if( !$repeat ) {
  
    $controller = $smarty->_tpl_vars['controller'];
  
    // Build url
    if( isset( $params['url'] ) ) {
      
      $url = $params['url'];
      
    } else {
    	
    	/*if( !isset( $params['plugin'] ) && $controller['plugin'] ) {
    		$params['plugin'] = $controller['plugin'];
    	}*/
    	
      if(! isset( $params['controller'] ) ) {
  	    $params['controller'] = $controller['name'];
      }
    
      /*if(! isset( $params['action'] ) ) {
  	    $params['action'] = $controller['action'];
      }*/
      
      $params['href'] = UrlBuilder::from_array($params);
      
      // Cleanup params
      $i = 1;
      while( isset( $params["arg$i"] ) ) {
    	  unset( $params["arg$i"] );
    	  $i++;
      }
      unset( $params['controller'], $params['action'] );
    
      
    }
    
    return HtmlBuilder::build_tag('a',$params,$content);
    
  }
  
}

?>