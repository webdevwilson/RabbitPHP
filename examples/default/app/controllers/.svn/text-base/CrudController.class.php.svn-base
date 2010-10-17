<?php
/**
 * Crud Controller for rabbit. 
 */

class CrudController extends Controller{
    
    protected $do_name;
    protected $blank_do;
    protected $do_class_map;
    protected $do_fields;
    protected $primitive_fields;
    protected $relational_fields;
    protected $field_listing;
    protected $view_data; 
    protected $ezpdo_get_do_func;
    protected $ezpdo_create_do_func;
    protected $ezpdo_count_do_funct;
    protected $ezpdo_list_do_func;
    protected $controller_path;

    
    /**
     * setup all of the extra crud controller variables, discover the ezpdo domain object relationships, etc.
     */
    public function before_action(){
        $this->do_name              = strtolower(preg_replace('/^[a-zA-Z]*_/', '', str_replace('ManagerController', '', get_class($this))));
        $this->controller_path      = (!$this->plugin) ? "/{$this->name}" : "/{$this->plugin}/{$this->name}";
        $this->ezpdo_get_do_func    = "get_{$this->do_name}";
        $this->ezpdo_create_do_func = "create_{$this->do_name}";
        $this->ezpdo_count_do_func  = "count_{$this->do_name}";
        $this->ezpdo_list_do_func   = "list_{$this->do_name}";
        
        //create the domain object
        $this->blank_do         = $this->manager->{$this->ezpdo_create_do_func}();
        $this->do_class_map     = $this->blank_do->epGetClassMap();
        $this->do_fields        = $this->do_class_map->getAllFields();
        $this->primitive_fields = array();
        $this->relational_fields= array();
        $this->field_listing    = array();
        $this->view_data        = array();
               
        //Programmatically discover the ezpdo database schema separating
        //out the primitive database fields from the actual object relationships
        foreach ($this->do_fields as $field_name=>$field_map){
            if ($field_map instanceof epFieldMapPrimitive)
                $this->primitive_fields[$field_name] = $field_map;
            else if ($field_map instanceof epFieldMapRelationship){
                $this->relational_fields[$field_name] = $field_map;                
                $all_entries = $this->manager->query("from {$field_map->getBase_b()}");
                $this->view_data['related_objects'][$field_name] = $all_entries;
                foreach ($all_entries as $entry)
                    $this->view_data['relation_tables'][$field_name][$entry->oid] = (string)$entry;
            }
        }

    }

    public function index() {
        $this->redirect('listall');			
    }

    
    /**
     * this controller action lets the user create a domain object; it presents a validating form to them with 
     * domain object parameters relationships represented as form fields
     * @return array an array containing a blank {@link DomainObject} or a {@link DomainObject} filled in with 
     * the values the user has entered into the form (in the case of an invalid form entry) so that the form 
     * will be autofilled with the values
     */
    public function create(){
        
        if ($this->params['action']=='Save'){
            
            //Create a new domain object
            $new_do = $this->manager->{$this->ezpdo_create_do_func}();
            
            //Read the values they put into the form into the domain object
            foreach ($this->params['model'][$this->do_name] as $input_name=>$input_value){
                if (isset($this->primitive_fields[$input_name]))
                    $new_do->$input_name = $input_value; 
                
                else if (isset($this->relational_fields[$input_name])){
                    $get_domain_obj_func  = 'get_' . strtolower($this->relational_fields[$input_name]->getBase_b()); 
                    if ($this->relational_fields[$input_name]->isHasMany() || $this->relational_fields[$input_name]->isComposedOfMany())
                        foreach ($input_value as $dont_care=>$id)
                            $new_do[$input_name][] = $this->manager->$get_domain_obj_func($id);

                    else if ($this->relational_fields[$input_name]->isHasOne() || $this->relational_fields[$input_name]->isComposedOfOne())
                        $new_do[$input_name] = $this->manager->$get_domain_obj_func($input_value);

                    else
                        die("$this->name::create encountered an unknown relationship type!");
                }
            }
           
            //if the domain object validates and commits
            if ($new_do->is_valid() && $this->before_create($new_do) && $this->manager->commit($new_do)){
                $this->flash->message = 'Post successfully created.';
                $this->after_create($new_do);
                $this->redirect("{$this->controller_path}/read/" . $new_do->oid);
            }
            
            //otherwise, tell the user we encountered an error, represent the form and let them try to fill it out again
            else{
                $this->flash->error                   = 'We\'re sorry, but there were problems with your form submission. Please correct it and resubmit.';
                $this->view_data[$this->do_name]      = $new_do;
                return $this->view_data;
                
            }
        }
        
        //if the user clicked cancel, send them back to the list all page
        else if ($this->params['action'] == 'Cancel')
            $this->redirect("{$this->controller_path}/listall");

        //otherwise, they have not yet clicked anything, so simply present the form to the them
        else if (!isset($this->params['action'])){
            $this->view_data[$this->do_name] = $this->blank_do;
            return $this->view_data;
        }

        else
            die('Unknown action posted!');

    }

    /**
     * retrieve the desired {@link DomainObject} and presents its values to the user
     * @param int the id of the desired {@link DomainObject}
     * @return array an array with the {@link DomainObject}'s name as a key, and the value 
     *               the ezpdo value of that domain object
     */
    public function read($id=0){
        
        $id = (int)$id;
        
        if ($id<1){
            $this->flash->error = "Sorry, but the id provided was invalid. ";
            $this->redirect("{$this->controller_path}/listall");
        }
        
        if ( ! ($do = $this->manager->{$this->ezpdo_get_do_func}($id)) ){
            $this->flash->error = "Sorry, but we can't find a {$this->do_name} with that id.";
            $this->redirect("{$this->controller_path}/listall");
        }
        
        $do->created = date('F d, Y h:i:s A', $do->created);
        $do->updated = date('F d, Y h:i:s A', $do->updated);

        $this->view_data[$this->do_name] = $do;
        
        return $this->view_data;

    }

    /**
     * present a form to the user for updating an existing {@link DomainObject}
     * @param int the id of the desired {@link DomainObject}
     * @return array an array with the {@link DomainObject}'s name as a key, and the value 
     *               the ezpdo value of that domain object
     */
    public function update($id=0){
        
        $id = (int)$id;

        if ($id<1){
            $this->flash->error = "id($id) is invalid!";
            $this->redirect("{$this->controller_path}/listall");
        }
        
        if ( ! ($do = $this->manager->{$this->ezpdo_get_do_func}($id)) ){
            $this->flash->error = "Sorry, but we can't find a $this->do_name where id=$id";
            $this->redirect("{$this->controller_path}/listall");
        }
        
        if ($this->params['action']=='Save'){
            
            //Read the values they put into the form into the domain object
            foreach ($this->params['model'][$this->do_name] as $input_name=>$input_value){
                if (isset($this->primitive_fields[$input_name]))
                    $do->$input_name = $input_value; 
                
                else if (isset($this->relational_fields[$input_name])){
                    $get_domain_obj_func  = 'get_' . strtolower($this->relational_fields[$input_name]->getBase_b()); 
                                    
                    if ($this->relational_fields[$input_name]->isHasMany() || $this->relational_fields[$input_name]->isComposedOfMany()){
                        $do[$input_name]->removeAll();
                        foreach ($input_value as $dont_care=>$id)
                            $do[$input_name][] = $this->manager->$get_domain_obj_func($id);
                    }

                    else if ($this->relational_fields[$input_name]->isHasOne() || $this->relational_fields[$input_name]->isComposedOfOne())
                        $do[$input_name] = $this->manager->$get_domain_obj_func($input_value);
                    else
                        die("$this->name::create encountered an unknown relationship type!");
                }
            }
           
            //if the domain object validates and commits
            if ($do->is_valid() && $this->before_update($do) && $this->manager->commit($do)){
                $this->flash->message = 'Post successfully created.';
                $this->after_update($do);
                $this->redirect("{$this->controller_path}/read/" . $do->oid);
            }
            
            //otherwise, tell the user we encountered an error, represent the form and let them try to fill it out again
            else{
                $this->flash->error                   = 'We\'re sorry, but there were problems with your form submission. Please correct it and resubmit.';
                $this->view_data[$this->do_name]      = $do;
               
                return $this->view_data;
            }
        }
        
        //if the user clicked cancel, send them back to the list all page
        else if ($this->params['action'] == 'Cancel')
            $this->redirect("{$this->controller_path}/listall");

        //otherwise, they have not yet clicked anything, so simply present the form to the them
        else if (!isset($this->params['action'])){
            $this->view_data[$this->do_name] = $do;
            return $this->view_data;
        }

        else
            die('Unknown action posted!');
    }

    
    /**
     * present a form to the user for deleting an existing {@link DomainObject}
     * @param int the id of the desired {@link DomainObject}
     * @return array an array with the {@link DomainObject}'s name as a key, and the value 
     *               the ezpdo value of that domain object
     */
    public function delete($id=0){
        $id = (int)$id;
        if ($id<1){
            $this->flash->error = "id($id) is invalid!";
            $this->redirect("{$this->controller_path}/listall");
        }
        

        else if ( ! ($do = $this->manager->{$this->ezpdo_get_do_func}($id)) ){
            $this->flash->error = "Sorry, but we can't find a $this->do_name where id=$id";
            $this->redirect("{$this->controller_path}/listall");
        }
       

        if ($this->params['action'] == 'Cancel'){
            $this->flash->message = 'Delete cancelled';
            $this->redirect("{$this->controller_path}/listall");
        }

        else if ($this->params['action'] == 'Delete'){
            $do_textual = (string)$do;

            if ($this->before_delete($do) && !$this->manager->delete($do)){
                $this->flash->error = 'Unexpected error during delete';
                $this->redirect("{$this->controller_path}/read/" . $post->prettylink);
            }

            $this->flash->message = "Successfully deleted \"$do_textual\"";
            $this->after_delete($do);
            $this->redirect("{$this->controller_path}/listall");
            
        }

        else if (!empty($this->params['action']))
            die('Unknown action posted!');
        
        
        $do->created = date('F d, Y h:i:s A', $do->created);
        $do->updated = date('F d, Y h:i:s A', $do->updated);

        $this->view_data[$this->do_name] = $do;
        
        return $this->view_data;
    }

    /**
     * paginated lists of the desired {@link DomainObject}
     * @param int if there are multiple pages of the {@link DomainObject}, this represents the current page
     * @param int how many {@link DomainObject}s to display on a page
     * @param int at the bottom of the page, there are links to other pages in the case that there are multiple pages of results. 
     * @return array an array with the {@link DomainObject}'s name as a key, and the value 
     *               the ezpdo value of that domain object
     */
    public function listall($page=1, $num_per_page=2, $num_page_links_visible=3){
        //workaround for the bug where $page might get passed an empty string even though 
        //no parameter was provided in the url
        $page                   = (int)$page;
        $num_per_page           = (int)$num_per_page;
        $num_page_links_visible = (int)$num_page_lins_visible;

        if (empty($page) || $page < 1)
            $page=1;
        if (empty($num_per_page) || $num_per_page<1)
            $num_per_page=2;
        if (empty($num_page_links_visible) || $num_page_links_visible<1)
            $num_page_links_visible=3;
             
        $total_num_pages = ceil(($this->manager->{$this->ezpdo_count_do_func}() / $num_per_page));
        $first_half_num_page_links_visible = floor( $num_page_links_visible / 2) ;
        $second_half_num_page_links_visible = ($num_page_links_visible%2 == 0 ? $first_half_num_page_links_visible -1 : $first_half_num_page_links_visible );
        
        if ($total_num_pages < $num_page_links_visible){
            $first_page_link = 1; 
            $last_page_link = $total_num_pages;
        }
        else{
            $first_page_link = ($page - $first_half_num_page_links_visible ) < 1 ? 1 : ($page - $first_half_num_page_links_visible );
            if ($first_page_link == 1)
                $last_page_link = ($num_page_links_visible < $total_num_pages) ? $num_page_links_visible : $total_num_pages;
            else 
                $last_page_link = $total_num_pages < ($page+$second_half_num_page_links_visible) ? $total_num_pages : ($page+$second_half_num_page_links_visible);
            if ($last_page_link - ($first_page_link-1) < $num_page_links_visible && $total_num_pages > $num_page_links_visible && $first_page_link > 1)
                $first_page_link-=($num_page_links_visible - ($last_page_link - ($first_page_link -1)));
        }
       
        $this->view_data['first_page_link']       = $first_page_link;
        $this->view_data['last_page_link']        = $last_page_link;
        $this->view_data['num_page_links_visible']= $num_page_links_visible;
        $this->view_data['page_nums']             = range($first_page_link, $last_page_link);
        $this->view_data['total_num_pages']       = $total_num_pages;
        $this->view_data['num_page_links_visible']= $num_page_links_visible;
        $this->view_data['current_page']          = $page;
        $this->view_data['num_per_page']          = $num_per_page;
        $this->view_data['total']                 = $this->manager->{$this->ezpdo_count_do_func}();
        $this->view_data[$this->do_name.'s']      = $this->manager->{$this->ezpdo_list_do_func}(
                                                        array(
                                                          'order' => 'created asc',
                                                          'start' => ($page - 1) * $num_per_page,
                                                          'max'   => $num_per_page
                                                        )
                                                      );
        return $this->view_data;
    }

    /**
     * before create event fired before a domain object is created
     * @param object the object being created
     * @return bool true if create should proceed, false to stop
     */
    protected function before_create($object) {
        return true;
    }

    /**
     * after create event fired after a domain object is created
     * @param object the object that was created
     */
    protected function after_create($object) {
        return;
    }
    
    /**
     * before update event fired before a domain object is updated
     * @param object the object being deleted
     * @return bool true if create should proceed, false to stop
     */
    protected function before_update($object) {
        return true;
    }

    /**
     * after update event fired after a domain object is updated
     * @param object the object that was updated
     */
    protected function after_update($object) {
        return;
    }
    
    /**
     * before delete event fired before a domain object is deleted
     * @param object the object being deleted
     * @return bool true if create should proceed, false to stop
     */
    protected function before_delete($object) {
        return true;
    }

    /**
     * after delete event fired after a domain object is deleted
     * @param object the object that was deleted
     */
    protected function after_delete($object) {
        return;
    }      
}


?>
