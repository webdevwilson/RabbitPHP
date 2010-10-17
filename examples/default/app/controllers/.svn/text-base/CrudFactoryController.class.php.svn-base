<?
class CrudFactoryController extends Controller{
    
    protected $do_name;
    protected $do_plugin_name;
    protected $do;
    protected $class_map;
    protected $primitive_fields;
    protected $relational_fields;
    protected $field_listing;
    protected $view_data;
    protected $controller_path;
    protected $action_log;

    public function before_action(){
        if ($this->action !== 'make')
            die('You must call the "make" action on this controller.');
        
        //if they didn't specify a plugin or a domain object
        else if (empty($this->url_components[2]) && empty($this->url_components[3]) )
            die('You must either specify a domain object, or a plugin AND a domain object!');
        
        //if they only specified a domain object, but not a plugin 
        else if (!empty($this->url_components[2]) && empty($this->url_components[3])){
            $this->do_name          = $this->url_components[2];
            $this->do_plugin_name   = false;
            $this->controller_path  = "/{$this->do_name}_manager";
        }
        
        //if they specified both a plugin AND a domain name
        else if (!empty($this->url_components[2]) && !empty($this->url_components[3])){
            $this->do_plugin_name   = $this->url_components[2];
            $this->do_name          = $this->url_components[3];
            $this->controller_path  = "/{$this->do_plugin_name}/{$this->do_name}_manager";
        }

        else
            die('unknown condition in CrudFactoryController');

        $create_do_func         = "create_{$this->do_name}";
        $this->do               = $this->manager->$create_do_func();
        $this->do_class_map     = $this->do->epGetClassMap();
        $this->do_fields        = $this->do_class_map->getAllFields();
        $this->primitive_fields = array();
        $this->relational_fields= array();
        $this->field_listing    = array();
        $this->view_data        = array();

        //Programmatically discover the ezpdo database schema separating
        //out the primitive database fields from the actual object relationships
        foreach ($this->do_fields as $field_name=>$field_map)
            if ($field_map instanceof epFieldMapPrimitive)
                $this->primitive_fields[$field_name] = $field_map;
            else if ($field_map instanceof epFieldMapRelationship)
                $this->relational_fields[$field_name] = $field_map;                
        
        $this->view_data['primitive_fields']  = $this->primitive_fields; 
        $this->view_data['relational_fields'] = $this->relational_fields;
    }
   

    public function make($do_plugin_name, $domain_object_name){
        
        //First, create the tpl files
        $create_tpl = $this->make_create_tpl();
        $read_tpl   = $this->make_read_tpl();
        $update_tpl = $this->make_update_tpl();
        $delete_tpl = $this->make_delete_tpl();
        $listall_tpl= $this->make_listall_tpl();
        
        //Next, make the controller class file
        $do_controller = $this->make_do_controller_class();
        
        if (false !== $this->do_plugin_name)
            $prefix = APP_BASE . "/plugins/{$this->do_plugin_name}";
        else
            $prefix = APP_BASE;
        
        //Lastly, write these out to file
        $this->cat_file("$prefix/controllers/".ucfirst($this->do_name)."ManagerController.class.php",     $do_controller);
        $this->cat_file("$prefix/view/" . strtolower($this->do_name) . '_manager/create.tpl',  $create_tpl);
        $this->cat_file("$prefix/view/" . strtolower($this->do_name) . '_manager/read.tpl',    $read_tpl);
        $this->cat_file("$prefix/view/" . strtolower($this->do_name) . '_manager/update.tpl',  $update_tpl);
        $this->cat_file("$prefix/view/" . strtolower($this->do_name) . '_manager/delete.tpl',  $delete_tpl);
        $this->cat_file("$prefix/view/" . strtolower($this->do_name) . '_manager/listall.tpl', $listall_tpl);

        return array('crud_factory_output' => $this->action_log);
    }

    protected function cat_file($file_path, $file_contents){
        $directory_path = dirname($file_path);
        
        if (is_dir($directory_path)){
            $this->action_log .= "\nThe directory '$directory_path' already exists. Skipping directory creation.";
        }
        //Attempt to make the directory if it doesn't exist already
        else if (!mkdir($directory_path,0757,true)){
            $this->action_log .= "\nCould not make directory '$directory_path'. Check permissions and try again.";
            return false;
        }

        //attempt to open the file for writing
        $file_handle = fopen($file_path, 'w');
        if (!$file_handle){
            $this->action_log .= "\nCouldn't open file '$file_path' for writing. Check permissions and try again.";
            return false;
        }

        if (false == fwrite($file_handle, $file_contents)){
            $this->action_log .= "\nError writing to file '$file_path'. Check permissions and try again.";
            return false;
        }
        fclose($file_handle);
        
        $this->action_log .= "\nSuccessfully wrote to file '$file_path'.";
        return true;
    }

    protected function make_do_controller_class(){
        $do_name = ucfirst($this->do_name);
        $php = <<<CONTROLLERCLASS
<?
class {$do_name}ManagerController extends CrudController{

}
?>
CONTROLLERCLASS;
        return $php;
    }

    protected function make_create_tpl(){
        $html = <<<CREATEHEADER
{render_element element="messages"}
<h1 class="form-heading">Create {$this->do_name}</h1>
<form action="{$this->controller_path}/create" method="post" enctype="multipart/form-data">
CREATEHEADER;
        
        foreach ($this->primitive_fields as $field_name=>$primitive_field_map){
            if ($field_name !== 'created' && $field_name !=='updated'){
                $func = $primitive_field_map->getType().'_field';
                $html.="\n" . DomainFormFieldMap::$func($this->do_name, $field_name);
            }
        }

        foreach ($this->relational_fields as $field_name=>$relational_field_map)
            if ($relational_field_map->isHasMany() || $relational_field_map->isComposedOfMany())
                $html.="\n" . DomainFormFieldMap::has_many_field($this->do_name, $field_name);
            else if ($relational_field_map->isHasOne() || $relational_field_map->isComposedOfOne())
                $html.="\n" . DomainFormFieldMap::has_one_field($this->do_name, $field_name);
        
        $html .= <<<CREATEFOOTER
<div class="buttons">
    <input type="submit" name="action" value="Save" />
    <input type="submit" name="action" value="Cancel" />
</div>
</form>
CREATEFOOTER;
        
        return $html;
    }
    
    
    protected function make_update_tpl(){
        $html ='
{render_element element="messages"}
<h1 class="form-heading">Create '.$this->do_name.'</h1>
<form action="'.$this->controller_path.'/update/{$'.$this->do_name.'->oid}" method="post" enctype="multipart/form-data">
';
        
        foreach ($this->primitive_fields as $field_name=>$primitive_field_map){
            if ($field_name !== 'created' && $field_name !== 'updated'){
                $func = $primitive_field_map->getType().'_field';
                $html.="\n" . DomainFormFieldMap::$func($this->do_name, $field_name);
            }
        }

        foreach ($this->relational_fields as $field_name=>$relational_field_map)
            if ($relational_field_map->isHasMany() || $relational_field_map->isComposedOfMany())
                $html.="\n" . DomainFormFieldMap::has_many_field($this->do_name, $field_name);
            else if ($relational_field_map->isHasOne() || $relational_field_map->isComposedOfOne())
                $html.="\n" . DomainFormFieldMap::has_one_field($this->do_name, $field_name);
        
        $html .='
<div class="buttons">
    <input type="submit" name="action" value="Save" />
    <input type="submit" name="action" value="Cancel" />
</div>
</form>
';
        
        return $html;
    }

    
    protected function make_read_tpl(){
        $html ='
{render_element element="messages"}
<h1>Read '.$this->do_name.'</h1>
<table>
';
        foreach ($this->primitive_fields as $field_name=>$field_map)
            $html.='
  <tr>
    <td><b>'.$field_name.'</b></td>
    <td>{$'.$this->do_name.'.'.$field_name.'|nl2br}</td>
  </tr>
';

        foreach ($this->relational_fields as $field_name=>$field_map){
            if ($field_map->isHasOne() || $field_map->isComposedOfOne())
                $html.='
  <tr>
    <td><b>'.$field_name.'</b></td>
    <td>{$'.$this->do_name.'.'.$field_name.'|nl2br}</td>
  </tr>
                ';
            else if ($field_map->isHasMany() || $field_map->isComposedOfMany())
                $html.='
  <tr>
    <td><b>'.$field_name.'</b></td>
    <td>{implode glue=", " pieces=$'.$this->do_name.'.'.$field_name.'}</td>
  </tr>
                ';
        }

        $html.='
       </table>
<br><br>
<a href="'.$this->controller_path.'/update/{$'.$this->do_name.'.id}">Update</a> - <a href="'.$this->controller_path.'/delete/{$'.$this->do_name.'.id}">Delete</a> - <a href="'.$this->controller_path.'/listall">List All</a>
';

        return $html;
    }

    protected function make_delete_tpl(){
        $html='
{render_element element="messages"}
<h1 class="form-heading">Delete '.$this->do_name.'?</h1>
<form action="'.$this->controller_path.'/delete/{$'.$this->do_name.'->oid}" method="post" enctype="multipart/form-data">
<table>
';

        foreach ($this->primitive_fields as $field_name=>$field_map)
            $html.='
  <tr>
    <td><b>'.$field_name.'</b></td>
    <td>{$'.$this->do_name.'.'.$field_name.'|nl2br}</td>
  </tr>
';

        foreach ($this->relational_fields as $field_name=>$field_map){
            if ($field_map->isHasOne() || $field_map->isComposedOfOne())
                $html.='
  <tr>
    <td><b>'.$field_name.'</b></td>
    <td>{$'.$this->do_name.'.'.$field_name.'|nl2br}</td>
  </tr>
                ';
            else if ($field_map->isHasMany() || $field_map->isComposedOfMany())
                $html.='
  <tr>
    <td><b>'.$field_name.'</b></td>
    <td>{implode glue=", " pieces=$'.$this->do_name.'.'.$field_name.'}</td>
  </tr>
                ';
        }

        $html.='
</table>

<br><br>
<div class="buttons">
    <input type="submit" name="action" value="Delete" />
    <input type="submit" name="action" value="Cancel" />
</div>
</form>
<br>
';
        return $html;
    }

    protected function make_listall_tpl(){
        $html='
<h1>'.ucfirst($this->do_name).'s</h1>
{render_element element="messages"}
<a href="'.$this->controller_path.'/create">Create</a> new '.$this->do_name.'
<br><br>
<ul style="margin: 0px; padding: 0px; " >

{foreach from="$'.$this->do_name.'s" item="'.$this->do_name.'"}
<li style="list-style-type: none; background-color: {cycle values="#eeeeee,#d0d0d0"}">
    <a href="'.$this->controller_path.'/read/{$'.$this->do_name.'->oid}">{$'.$this->do_name.'}</a> - 
    <a href="'.$this->controller_path.'/update/{$'.$this->do_name.'->oid}">Update</a> - 
    <a href="'.$this->controller_path.'/delete/{$'.$this->do_name.'->oid}">Delete</a>
</li>
{/foreach}
</ul>
<br>
{* display the page links *}
{if $total_num_pages>0}
    {counter assign="i" start=$first_page_link}
    {if $first_page_link!=1 && $num_page_links_visible<$total_num_pages}
    <a href="'.$this->controller_path.'/listall/1/{$num_per_page}/{$num_page_links_visible}">&lt;&lt;</a>&nbsp;
    <a href="'.$this->controller_path.'/listall/{$current_page-1}/{$num_per_page}/{$num_page_links_visible}">&lt;</a>&nbsp;
    {/if}
    {foreach from=$page_nums item="page_num"}

    {if $page_num==$current_page}
    {$page_num}{if $i!=$last_page_link}&nbsp;-&nbsp;{/if}
    {else}
    <a title="Page {$page_num}" href="'.$this->controller_path.'/listall/{$page_num}/{$num_per_page}/{$num_page_links_visible}">{$page_num}</a>{if $i!=$last_page_link}&nbsp;-&nbsp;{/if}
    {/if}
    {counter}
    {/foreach}
    {if $last_page_link!=$total_num_pages}
    &nbsp;<a href="'.$this->controller_path.'/listall/{$current_page+1}/{$num_per_page}/{$num_page_links_visible}">&gt;</a>&nbsp;
    <a href="'.$this->controller_path.'/listall/{$total_num_pages}/{$num_per_page}/{$num_page_links_visible}">&gt;&gt;</a>&nbsp;
    {/if}
{/if}
        ';
        
        return $html;
    }
}

?>
