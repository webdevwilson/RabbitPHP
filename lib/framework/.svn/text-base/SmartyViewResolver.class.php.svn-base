<?php
/**
* Defines SmartyViewResolver class, a class which uses smarty for view manipulation
* @package RabbitPHP
* @subpackage Framework
* @author Kerry R Wilson <kerry@rabbitphp.org>
* @version 0.4
*/

/**
* SmartyViewResolver class is used for rendering Smarty view files (.tpl)
*/
class SmartyViewResolver extends ViewResolver {

    private $smarty;

    public function initialize($model) {
        
        // create a smarty object
        $this->smarty = SmartyFactory::create();
        
        // add model objects to smarty
        foreach( $model as $name => $value ) {
            $this->smarty->assign($name,$value);
        }
        
    }

    public function render_view($view_name) {
        
        $view_file = ResourceLoader::get_view_file($view_name.'.tpl');    
        return $this->smarty->fetch('file:'.$view_file);
    }

    public function render_layout($layout, $view) {
        
        $this->smarty->assign('view', $view);
            
        $layout_file = ResourceLoader::instance()->get_layout_file($layout.'.tpl');
        
        $rendered_view = $this->smarty->fetch('file:'.$layout_file);
        
        return $this->head_replacements($rendered_view);
    }
    
    private function head_replacements($rendered_view) {

        // Add the requested javascript libraries to the request

        if( is_array( $this->smarty->_tpl_vars['rabbitphp_smartytags_script_html_scripts'] ) ) {
            $libraries = array();
            $jsconfig = parse_ini_file( APP_BASE.'/webroot/scripts/dependencies.ini', true );
            foreach( $this->smarty->_tpl_vars['rabbitphp_smartytags_script_html_scripts'] as $library ) {

                if(! empty($jsconfig[$library]) ) {
                    $dependencies = explode(',',$jsconfig[$library]);
                    foreach( $dependencies as $d ) {
                        if( !in_array($d,$libraries) ) {
                            $libraries[] = $d;
                        }
                    }
                }
                if( !in_array($library,$libraries) ) {
                    $libraries[] = $library;
                }
            }

            $scripts = '';
            foreach( $libraries as $lib ) {
                    if( substr( $lib, 0, 7 ) == 'http://' ) {
                            $scripts .= "<script type=\"text/javascript\" src=\"$lib\"></script>\r\n";
                    } else { 
                            $src = str_replace('.','/',$lib);
                            $scripts .= "<script type=\"text/javascript\" src=\"/scripts/${src}.js\"></script>\r\n";
                    }
            }
            $rendered_view = str_replace('</head>',$scripts.'</head>',$rendered_view);
        }

        // add anything that was added with a head tag
        if( isset( $this->smarty->_tpl_vars['rabbitphp_smartytags_head_content'] ) ) {
            $rendered_view = str_replace('</head>',$this->smarty->_tpl_vars['rabbitphp_smartytags_head_content'].'</head>',$rendered_view);
        }
        
        return $rendered_view;
    }

}

?>
