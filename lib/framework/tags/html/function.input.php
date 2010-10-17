<?php
/**
 * Defines the input smarty tag, which is used for form input
 * @package RabbitPHP_Tags
 * @subpackage Html
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
function smarty_function_input($params,&$smarty) {
  static $calendar_included = false;
  // Resolve model name
  if( isset( $params['model'] ) ) {
    $model_args = explode('.',$params['model']);
    list($model_name,$model_field) = $model_args;
    
    $value = $smarty->_tpl_vars[$model_name][$model_field];
    
    /******* ADDED by moonmaster9000 **********************
     * if the "value" (i.e., the representation of what the user specified in the form field) 
     * is passed to us as an ezpdo object or an epArray of ezpdo objects, we'll convert that using the 
     * id's of the ezpdo objects
    *******************************************************/
    if ($value instanceof epArray && count($value) > 0){
      $params['value'] = array();
      foreach ($value as $index=>$domain_object){
        if (is_object($domain_object))
          $params['value'][] = $domain_object->getId();
      }
    }
    else if ($value instanceof epArray && count($value) == 0)
        $params['value'] = array();
    else if ($value instanceof epObject)
        $params['value'] = $value->getId();
    else
        $params['value'] = $value;
    //********END ADDED by moonmaster9000 ******************/



    $params['name'] = "model[$model_name][$model_field]";
    
    $params['id'] = "$model_name.$model_field";
    
    unset( $params['model'] );
    
    // Set the maxlength on password and text fields
    if( !isset( $params['maxlength'] ) &&
        ( $params['type'] == 'text' || $params['type'] == 'password' ) &&
        isset( $smarty->_tpl_vars[$model_name]->constraints[$model_field]['max_length'] ) ) {
      $params['maxlength'] = $smarty->_tpl_vars[$model_name]->constraints[$model_field]['max_length'];
    }
    
  }
      
  if( !isset($params['id']) ) {
  	$params['id'] = $params['name'];
  }
  
  switch( $params['type'] ) {
  	
  	case 'text':
  	case 'password':
  	case 'hidden':
  	case 'radio':
  	case 'checkbox':
    case 'submit':
      
      // Do textbox prepopulate
  	  if( !isset( $params['value'] ) && $params['type'] == 'text' ) {
  	  	if( isset( $smarty->_tpl_vars['params'][$params['name']] ) ) {
  	  		$params['value'] = $smarty->_tpl_vars['params'][$params['name']];
  	  	}
  	  }
  	  
  	  return HtmlBuilder::build_tag('input', $params);

    break;

    case 'date':
        $params['type'] = 'text';
        // Do textbox prepopulate
  	    if( !isset( $params['value'] ) && $params['type'] == 'text' ) {
  	  	    if( isset( $smarty->_tpl_vars['params'][$params['name']] ) ) {
  	  	    	$params['value'] = $smarty->_tpl_vars['params'][$params['name']];
  	  	    }
  	    }
        if (!$calendar_included){
            $calendar_included = true;
            $cal_name = 'cal_popup_for_' . str_replace(array('[',']'),'_',$params['name']);
            $params['onclick'] = '';
            $form_name = isset($params['form_name'])?"forms['{$params['form_name']}']":'forms[0]';
	        return 
                '<script type="text/javascript">'
                    .FileUtilities::get_file_contents(RABBITPHP_HOME . '/lib/javascript/rabbitphp/calendar.js').
                "   
                    var $cal_name = new CalendarPopup('{$cal_name}_div');
                    $cal_name.showYearNavigation();
                    $cal_name.showYearNavigationInput();
                </script>" . 
                HtmlBuilder::build_tag('input', $params) . '
                <A  HREF="#"
                    onClick="'.$cal_name.'.select(document.'.$form_name.'[\''.$params['name'].'\'],\''.$cal_name.'_anchor\',\'MM/dd/yyyy\'); return false;"
                    NAME="'.$cal_name.'_anchor" ID="'.$cal_name.'_anchor">select</A>
                <DIV ID="'.$cal_name.'_div" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>
                '
                ;
        }
        else{
            $cal_name = 'cal_popup_for_' . str_replace(array('[',']'),'_',$params['name']);
            $params['onclick'] = '';
            $form_name = isset($params['form_name'])?"forms['{$params['form_name']}']":'forms[0]';
            unset($params['form_name']);
	        return 
                '<script type="text/javascript">'
                ."  
                    var $cal_name = new CalendarPopup('{$cal_name}_div');
                    $cal_name.showYearNavigation();
                    $cal_name.showYearNavigationInput();
                </script>" . 
                HtmlBuilder::build_tag('input', $params) . '
                <A  HREF="#"
                    onClick="'.$cal_name.'.select(document.'.$form_name.'[\''.$params['name'].'\'],\''.$cal_name.'_anchor\',\'MM/dd/yyyy\'); return false;"
                    NAME="'.$cal_name.'_anchor" ID="'.$cal_name.'_anchor">select</A>
                <DIV ID="'.$cal_name.'_div" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>
                '
                ;
        }
    break;
 

    case 'textarea':
      
      // Do prepopulate
  	  if( !isset( $params['value'] ) ) {
  	  	if( isset( $smarty->_tpl_vars['params'][$params['name']] ) ) {
  	  		$params['value'] = $smarty->_tpl_vars['params'][$params['name']];
  	  	}
  	  }
      
      return HtmlBuilder::build_tag('textarea', $params,$params['value']);
    
    break;
    
    case 'wysiwyg':
 
    	static $base_arguments = array();
      static $config_arguments = array();
 
    	include(RABBITPHP_HOME.'/lib/javascript/fckeditor/fckeditor.php');
    	
    	// Test if editor has been loaded before
	    if(!count($base_arguments)) $init = TRUE;
	    else $init = FALSE;
	     
	    $base_arguments['BasePath'] = '/scripts/fckeditor/';
	     
	    $base_arguments['InstanceName'] = $params['name'];
			
	    if(isset($params['value'])) $base_arguments['Value'] = $params['value'];
	    if(isset($params['width'])) $base_arguments['Width'] = $params['width'];
	    if(isset($params['height'])) $base_arguments['Height'] = $params['height'];
	    if(isset($params['toolbar'])) $base_arguments['ToolbarSet'] = $params['toolbar'];
	    if(isset($params['check_browser'])) $base_arguments['CheckBrowser'] = $params['check_browser'];
	    if(isset($params['display_errors'])) $base_arguments['DisplayErrors'] = $params['display_errors'];
			if(isset($params['user_files'])) $base_arguments['UserFilesPath'] = $params['user_files'];			
			
	    // Use all other parameters for the config array (replace if needed)
	    $other_arguments = array_diff_assoc($params, $base_arguments);
	    $config_arguments = array_merge($config_arguments, $other_arguments);
		  
		  $out = '';
	
	    if($init)
	    {
	    	$out .= '<script type="text/javascript" src="' . $base_arguments['BasePath'] . 'fckeditor.js"></script>';
	    }
	
	    $out .= "\n<script type=\"text/javascript\">\n";
	    $out .= "var oFCKeditor = new FCKeditor('" . $base_arguments['InstanceName'] . "');\n";
	
	    foreach($base_arguments as $key => $value)
	    {
	    	if(!is_bool($value))
	      {
	      	// Fix newlines, javascript cannot handle multiple line strings very well.
	        $value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"';
	      }
	      $out .= "\noFCKeditor.$key = $value; ";
	    }
	
	    foreach($config_arguments as $key => $value)
	    {
	    	if(!is_bool($value))
	      {
	      	$value = '"' . preg_replace("/[\r\n]+/", '" + $0"', addslashes($value)) . '"';
	      }
	      $out .= "oFCKeditor.Config[\"$key\"] = $value; ";
	    }
	
	    $out .= "\noFCKeditor.Create();\n";
	    $out .= "</script>\n"; 
	     
	    return $out;
    	
    break;
    
   
    case 'select':
      
  	  $options = array();
  	  
  	  $multiple = false;
  	  if( $params['multiple'] ) {
  	  	
        $params['extra'] = 'multiple';
  	  	$multiple = true;
       	
       	// Attempt to pull value from named parameter ( array, remove [] characters )
  	  	if( !is_array( $params['value'] ) ) {
  	  		if( isset( $smarty->_tpl_vars['params'][$params['name']] ) ) {
  	  			$params['value'] = $smarty->_tpl_vars['params'][$params['name']];
  	  		}
  	  	}
  	  	
  	  	$params['name'] .= '[]';
       	
  	  } else {
  	  	
     		// Do prepopulate
  	  	if( !isset( $params['value'] ) ) {
  	  		if( isset( $smarty->_tpl_vars['params'][$params['name']] ) ) {
  	  			$params['value'] = $smarty->_tpl_vars['params'][$params['name']];
  	  		}
  	  	}
  	  }
  	  
  	  if( isset( $params['option_name'] ) && isset( $params['option_value'] ) ) {
        foreach( $params['options'] as $o ) {
  	    	$option['name'] = 'option';
  	    	$option['attributes'] = array( 'value' => $o[$params['option_value']] );
  	    	$option['contents'] = $o[$params['option_name']];
  	    	
  	    	if( $multiple ) {
  	    		
  	    		if( is_array( $params['value'] ) && in_array( $o[$params['option_value']], $params['value'] ) ) {
  	    			$option['extra'] = 'selected';
  	    		}
  	    	
  	    	} else {
  	    		if( $params['value'] == $o[$params['option_value']] ) {
  	  		  	$option['extra'] = 'selected';
  	  	  	} else {
  	  	    	$option['extra'] = false;
  	      	}
  	    	}
  	    	$options[] = $option;
  	    }
  	  
  	  } else {
        
        /** ADDED by moonmaster9000 
         *
         * This makes it possible for the programmer to pass an array or an epArray of ezpdo objects to the input tags as the "options" 
         * We then convert that into a simple array where the index is the oid of the ezpdo object, and the value is the __toString() value
         * of the ezpdo object. 
         * For example, say you pass an array like: 
         * options = array(
                      epObject Tag:
                        id: 1
                        label: politics
                        definition: this tags is used to tag articles of a political nature
                        ,
                      epObject Tag:
                        id: 2
                        label: culture
                        definition: this tag is used to tag articles of a cultural nature
                      );
         * 
         * When this function finally renders out a select tag, it will look like this (assuming Tag's toString was defined to return the label field):
         * <select ..... >
         *  <option value="1">politics</option>
         *  <option value="2">culture</option>
         * </select>
         *
         **/
        if (is_array($params['options']) && !empty($params['options'])){
          $last_element = array_pop($params['options']);
          if ($last_element instanceof epObject){
            array_push($params['options'], $last_element);
            $options_domain_objects = $params['options'];
            $params['options'] = array();
            foreach ($options_domain_objects as $option_domain_object)
                $params['options'][$option_domain_object->getId()] = (string)$option_domain_object;
          }
        }
        else if ($params['options'] instanceof epArray){ 
            $options_domain_objects = $params['options'];
            $params['options'] = array();
            foreach ($options_domain_objects as $option_domain_object)
                
                $params['options'][$option_domain_object->getId()] = (string)$option_domain_object;
        }
        /** END added by moonmaster9000 */



        else if(! is_array($params['options']) ) {
            $new_options = array();
  	    	$options = explode(',',$params['options']);
  	    	foreach( $options as $opt ) {
  	    		
  	    		$split = explode('|',$opt);
  	    		if( is_array($split) && count( $split ) > 1 ) {
  	    		  $new_options[$split[1]] = $split[0];		
  	    		} else {
  	    			$new_options[$opt] = $opt;  
  	    		}
  	    		
  	    	}
  	    	$params['options'] = &$new_options;
  	    	
  	    }
  	    
  	    foreach( $params['options'] as $value => $label ) {
                $option = array();
                $option['name'] = 'option';
                $option['attributes'] = array( 'value' => $value );
                $option['contents'] = $label;
  	  	  
  	  	if( $multiple ) {
                    if( is_array( $params['value'] ) && in_array( $value, $params['value'] ) ) {
                            $option['extra'] = 'selected';
                    } else {
                            $option['extra'] = false;
                    }
                    } else {
                            if( $params['value'] == $value ) {
                            $option['extra'] = 'selected';
                    } else {
  	  	    	$option['extra'] = false;
                }
  	      }
            $options[] = $option;
  	    }
        unset( $params['options'] );
      
      }
      
      return HtmlBuilder::build_tag('select', $params, $options);
    
    break;
    
  }
}

?>
