<?php
/**
* Defines PhpViewResolver class, a class which uses php for views
* @package RabbitPHP
* @subpackage Framework
* @author Kerry R Wilson <kerry@rabbitphp.org>
* @version 0.4
*/

/**
* PhpViewResolver class uses standard php files for view (.php)
*/
class PhpViewResolver extends ViewResolver {

    public function render_view($view_name) {
        
        $view_file = ResourceLoader::get_view_file($view_name.'.php');
        
        if( !$view_file ) {
            return '';
        }

        // put model in current context
        extract( $this->model );
        
        ob_start();
        include( $view_file );
        return ob_get_clean();
    }

    public function render_layout($layout, $view) {
        
        // put model in current context
        extract( $this->model );    
        
        $layout_file = ResourceLoader::instance()->get_layout_file($layout.'.php');
        
        if( !$layout_file ) {
            return '';
        }
        
        ob_start();
        include( $layout_file );
        return ob_get_clean();
    }

}

?>