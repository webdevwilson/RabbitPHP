<?
/**
 * Defines class PluginInstaller, which installs plugins
 * @package RabbitPHP
 * @subpackage Utilities
 * @author Matt Parker <moonmaster9000@gmail.com>
 * @version 0.1
 **/
class PluginInstaller{
    
    protected $ignore_already_installed;
    protected $plugin_repos_dir;
    protected $app_plugin_dir;
    protected $nodes_visited; //used in the install/upgrade DFS for graph cycle detection
    
    function __construct($ignore_already_installed=false){
 
        $this->ignore_already_installed = $ignore_already_installed;
        $this->plugin_repos_dir         = RABBITPHP_HOME . '/lib/plugins-test';
        $this->app_plugin_dir           = APP_BASE . '/plugins';
        $this->nodes_visited            = array();
    }
    
    public function install_plugin($plugin, $version){
        print("PluginInstaller::install_plugin($plugin, $version)<br>");
        
        if (isset($this->nodes_visited[$plugin]))
            die('Detected cyclic dependencies: ' . implode(', ', $this->nodes_visited) . ", $plugin:$version");
        
        if (false === $this->plugin_exists($plugin, $version))
            die("$plugin:$version doesn't exist! <pre>" . implode(', ', $this->nodes_visited) . ", $plugin:$version");
       
        $this->nodes_visited[$plugin] = "$plugin:$version";

        if ($this->is_installed($plugin, $version))
            return true;

        if ($this->needs_upgrade($plugin, $version))
            return $this->upgrade_plugin($plugin, $version);
        
        else {
            $dependencies = $this->get_dependencies($plugin, $version);
            foreach ($dependencies as $dependency=>$version)
                if (false === $this->install_plugin($dependency, $version))
                    die("$dependency:$version failed to install");
            
            $this->copy_plugin_to_app($plugin, $version);
            $this->bootstrap_plugin($plugin);

            return true;
        }
    }
    
    protected function upgrade_plugin($plugin, $new_version){
        print("PluginInstaller::upgrade_plugin($plugin, $new_version)<br>");
        
        if ($this->is_installed($plugin, $new_version))
            return true;

        else if ($this->get_installed_plugin_version($plugin) > $new_version)
            return false;
        
        else {
            $current_version = $this->get_installed_plugin_version($plugin);
            $dependencies = $this->get_dependencies($plugin, $new_version);
            foreach ($dependencies as $dependency=>$version)
                $this->install_plugin($dependency, $version);

            $this->copy_plugin_to_app($plugin, $new_version);
            $this->upgrade_sql($plugin, $current_version, $new_version);
            $this->bootstrap_plugin($plugin);

            return true;
        }
    }

    protected function plugin_exists($plugin, $version){
        print("PluginInstaller::plugin_exists($plugin, $version)<br>");
        return PluginInspector::plugin_exists($plugin, $version);
    }

    protected function upgrade_sql($plugin, $from_version, $to_version){
        print("PluginInstaller::upgrade_sql($plugin, $from_version, $to_version)<br>");
 
    }

    protected function bootstrap_plugin($plugin){
        print("PluginInstaller::bootstrap_plugin($plugin)<br>");
        if (is_file("{$this->app_plugin_dir}/$plugin/bootstrap/" . ucfirst($plugin) . "Bootstrap.class.php")){
            require_once("{$this->app_plugin_dir}/$plugin/bootstrap/" . ucfirst($plugin) . "Bootstrap.class.php");
            $bootstrap_class_name = ucfirst($plugin) . "Bootstrap";
            new $bootstrap_class_name;
        }
    }

    protected function copy_plugin_to_app($plugin, $version){
        print("PluginInstaller::copy_plugin_to_app($plugin, $version)<br>");
        if (is_dir("{$this->app_plugin_dir}/$plugin"))
            rename("{$this->app_plugin_dir}/$plugin", "{$this->app_plugin_dir}/$plugin.archived." . date('dmY.U'));
        FileUtilities::rcopy("{$this->plugin_repos_dir}/$plugin/$version", "$this->app_plugin_dir/$plugin");
    }
    
    protected function get_dependencies($plugin, $version){
        print("PluginInstaller::get_dependencies($plugin, $version)<br>");
 
        return PluginInspector::get_dependencies($plugin, $version); 
    }

    protected function is_installed($plugin, $version=false){
        print("PluginInstaller::is_installed($plugin, $version)<br>");
        if (false === $version)
            return PluginInspector::is_installed($plugin);
        return PluginInspector::is_installed($plugin, $version);
    }

    protected function get_installed_plugin_version($plugin){
        print("PluginInstaller::get_installed_plugin_version($plugin)<br>");
 
        return PluginInspector::get_installed_plugin_version($plugin);
    }

    protected function needs_upgrade($plugin, $version){
        print("PluginInstaller::needs_upgrade($plugin, $version)<br>");
 
        return 
            $this->is_installed($plugin)
            &&
            !$this->is_installed($plugin, $version)
            && 
            (double)$version > (double)$this->get_installed_plugin_version($plugin);
    }
}
?>
