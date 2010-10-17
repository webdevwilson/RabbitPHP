<?php
/**
 * Defines ViewResolver interface, used to resolve views
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.4
 */

/**
 * ViewResolver class is used to render view and is the endpoint for
 * implementing various view technologies (php, smarty, etc...)
 */
class ViewResolver {

    protected $model;
    
    /**
     * Initialize the ViewResolver, default implementation sets model member variable
     *
     * @parameter Controller
     */
     public function initialize($model) {
         $this->model = $model;
     }

    /**
     * get the rendered view
     *
     * @parameter $view_name the view name
     * @return rendered html view
     */
    public function render_view($view_name) {
        return '';
    }
    
    /**
     * get the rendered layout
     *
     * @parameter $layout the name of the layout
     * @parameter $view the rendered view
     * @return rendered html layout
     */
     public function render_layout($layout, $view) {
         return '';
     }

}

?>
