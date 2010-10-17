<?
class PluginManagerController extends Controller{
    
    public function install($plugin, $version='0.01'){
        $pi = new PluginInstaller();
        ob_start();
        $pi->install_plugin($plugin, $version);
        $install_log = ob_get_clean();
        return array('install_log' => $install_log);
    }

    public function browse(){
        $all_plugins = array();
        $installed_plugins = PluginInspector::get_installed_plugin_inis();
        $available_plugins = PluginInspector::get_available_plugin_inis();
         
        foreach ($available_plugins as $plugin_name => $plugin_versions){
            $all_plugins[$plugin_name] = 
                array(
                    'name'                  => $plugin_name,
                    'is_installed'          => isset($installed_plugins[$plugin_name]) ? 'true' : 'false',
                    'installed_version'     => isset($installed_plugins[$plugin_name]) ? $installed_plugins[$plugin_name]['version'] : '',
                    'installable_versions'  => array(),
                    'old_versions'          => array()
                );
            foreach ($plugin_versions as $version => $ini)
                if (!isset($installed_plugins[$plugin_name]) 
                    || 
                    (isset($installed_plugins[$plugin_name]) && $version > $installed_plugins[$plugin_name]['version'])
                   )
                    $all_plugins[$plugin_name]['installable_versions'][$version] = $ini['description'];
                else
                    $all_plugins[$plugin_name]['old_versions'][$version] = $ini['description'];
            ksort($all_plugins[$plugin_name]['old_versions']);
            ksort($all_plugins[$plugin_name]['installable_versions']);
        }
        
        return array('all_plugins' => $all_plugins);
    }

}
?>
