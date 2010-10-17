<?php
/**
 * Defines HtmlBuilder Object
 * @package RabbitPHP
 * @subpackage Core
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
class HtmlBuilder extends Object {
  
  /**
   * Build an html tag
   *
   * @params string $name - the type of the tag
   * @params array $attributes - the attributes
   * @params string $contents - the contents
   * @return html representation of the tag
   */
  public static function build_tag($name,$attributes,$contents=false,$extra=false) {
    
    $html = '<'.$name;
    
    // Add attributes
    if( is_array( $attributes ) ) {
      foreach( $attributes AS $key => $value ) {
    	  $html .= ' '.$key.'="'.$value.'"';
      }
    }
    
    if( !$extra ) {
    	$extra = '';
    }
    
    if( $contents === false ) {
      
      $html .= " $extra/>";
    
    } else {
    	
    	// Nested tags
    	if( is_array( $contents ) ) {
    	  
    	  $html .= " $extra>";
    	  foreach( $contents AS $nested_tag ) {
    	    $html .= HtmlBuilder::build_tag($nested_tag['name'],$nested_tag['attributes'],$nested_tag['contents'],$nested_tag['extra']);
    	  }
    	  $html .= '</'.$name.'>';
    	
    	} else {
    	  $html .= " $extra>".$contents.'</'.$name.'>';	
    	}
    }
    
    return $html;
  }
  
  /**
   * Export something to javascript, handles boolean, string, integer, double, array, and objects ( calls to_array on epObjects )
   *
   * @param mixed $value value to export
   * @return javascript representation of value
   * @see epObject
   */
  public static function javascript_export($value) {
		
		$type = gettype($value);
		if ($type == "boolean") { return ($value) ? "Boolean(true)" : "Boolean(false)";	}
		elseif ($type == "integer") {	return "parseInt($value)"; }
		elseif ($type == "double") { return "parseFloat($value)"; }
		elseif ($type == "array" || $type == "object" ) {
			//
			// XXX Arrays with non-numeric indices are not
			// permitted according to ECMAScript, yet everyone
			// uses them.. We'll use an object.
			// 
			$s = "{ ";
			if ($type == "object") {
				
				if( $value instanceof epObject ) {
					$value = $value->to_array();
				} else {
					$value = get_object_vars($value);
				}
			
			}
			
			
			foreach ($value as $k=>$v) {
				$esc_key = HtmlBuilder::javascript_escape($k);
				if (is_numeric($k)) 
					$s .= "$k: " . HtmlBuilder::javascript_export($v) . ", ";
				else
					$s .= "\"$esc_key\": " . HtmlBuilder::javascript_export($v) . ", ";
			}
			if (count($value))
				$s = substr($s, 0, -2);
			return $s . " }";
		} else {
			$esc_val = HtmlBuilder::javascript_escape($value);
			$s = "'$esc_val'";
			return $s;
		}
  	
  }
  
  /**
   * Escape javascript
   *
   * @param string $val Value to escape
   * @return escaped value
   */
	function javascript_escape($val)
	{
		$val = str_replace("\\", "\\\\", $val);
		$val = str_replace("\r", "\\r", $val);
		$val = str_replace("\n", "\\n", $val);
		$val = str_replace("'", "\\'", $val);
		return str_replace('"', '\\"', $val);
	}

}

?>