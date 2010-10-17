<?php
/**
 * Defines the redirect smarty tag, which will redirect the user to the url defined by the url parameter, or by
 * the UrlBuilder from_array called with parameters
 *
 * <b>Parameters:</b><br />
 * url(optional) - The url to redirect to, if not present tag will use UrlBuilder::from_array method call
 * code(optional) - The HTTP status code, default is 301
 *
 * @package RabbitPHP_Tags
 * @subpackage Utility
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_redirect($params, &$smarty)
{
	if( isset( $params['url'] ) ) {
		$url = $params['url'];
	} else {
		$url = UrlBuilder::from_array($params);	
	}
	
	switch( $params['code'] ) {
		case 300:
			header("HTTP/1.1 300 Moved Permanently");
			break;
		case 302:
			header("HTTP/1.1 302 Found");
			break;
		case 303:
			header("HTTP/1.1 303 See Other");
			break;
		case 307:
			header("HTTP/1.1 307 Temporary Redirect");
			break;
		default:
		case 300:
			header("HTTP/1.1 301 Moved Permanently");
			break;
	}
	
	header("Location: ".$url);
	exit();
}
?>