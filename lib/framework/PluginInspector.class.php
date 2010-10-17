<?
/**
 * Defines class PluginManager, which contains static methods for discovering plugin inis
 * @package RabbitPHP
 * @subpackage Utilities
 * @author Matt Parker <moonmaster9000@gmail.com>
 * @version 0.1
 */
class PluginInspector {

    protected static $installed_plugins = false;
    protected static $available_plugins = false;

    /**
     * Get an array where the key is the name of the plugin, and the value is an 
     * array of setting_name/setting_value pairs parsed from the plugin.ini
     *
     * @return array of parsed ini's
    **/
    public static function get_installed_plugin_inis(){
        if (self::$installed_plugins !== false)
            return self::$installed_plugins;
        
        self::$installed_plugins = array();

        $directories = FileUtilities::get_directories(APP_PLUGINS);
        foreach ($directories as $plugin_dir_name=>$plugin_dir_contents){
            $plugin_dir_path = APP_PLUGINS . "/$plugin_dir_name";
            if (is_dir($plugin_dir_path))
                if (is_file("$plugin_dir_path/plugin.ini")) 
                    self::$installed_plugins[$plugin_dir_name] = self::parse_ini("$plugin_dir_path/plugin.ini");
        }
        return self::$installed_plugins;
    }
    
    /**
     * Get an array where the key is the name of the plugin, and the value is an 
     * array of setting_name/setting_value pairs parsed from the plugin.ini
     *
     * @return array of parsed ini's
     */
    public static function get_available_plugin_inis(){
        if (self::$available_plugins !== false)
            return self::$available_plugins;
        
        self::$available_plugins = array();
        
        $directories = FileUtilities::get_directories(PLUGIN_REPOS);
        foreach ($directories as $plugin_dir_name=>$plugin_dir_contents){
            $versions = FileUtilities::get_directories(PLUGIN_REPOS . "/$plugin_dir_name");
            foreach ($versions as $plugin_version=>$plugin_version_dir_contents){
                $plugin_dir_path = PLUGIN_REPOS . "/$plugin_dir_name/$plugin_version";
                if (is_dir($plugin_dir_path))
                    if (is_file("$plugin_dir_path/plugin.ini")){
                        $ini     = self::parse_ini("$plugin_dir_path/plugin.ini");
                        $version = (isset($ini['version']) && !empty($ini['version'])) ? $ini['version'] : '0.01';
                        self::$available_plugins[$plugin_dir_name][$version] = $ini;
                    }
            }
        }
        return self::$available_plugins;
    }

    /**
     * Determine if a plugin exists
     *
     * @return boolean 
     */
    public static function plugin_exists($plugin_name, $version=false){
        if (self::$installed_plugins === false)
            self::get_installed_plugin_inis();
        if (self::$available_plugins === false)
            self::get_available_plugin_inis();

        if ($version !== false)
            return 
                (isset(self::$installed_plugins[$plugin_name]['version']) && self::$installed_plugins[$plugin_name]['version'] == $version)
                ||
                isset(self::$available_plugins[$plugin_name][$version]);
            
        return isset(self::$installed_plugins[$plugin_name]) || isset(self::$available_plugins[$plugin_name]);
    }

    public static function is_installed($plugin_name, $version=false){
        if (self::$installed_plugins === false)
            self::get_installed_plugin_inis();

        if ($version !== false && !empty($version))
            return isset(self::$installed_plugins[$plugin_name]['version']) && self::$installed_plugins[$plugin_name]['version'] == $version;

        return isset(self::$installed_plugins[$plugin_name]);
    }

    public static function is_available($plugin_name, $version=false){
        if (self::$available_plugins === false)
            self::get_available_plugin_inis();

        if ($version !== false)
            return isset(self::$available_plugins[$plugin_name][$version]);

        return isset(self::$available_plugins[$plugin_name]);
    }

    /**
     * Get the version of an installed plugin
     *
     * @return boolean 
     */
    public static function get_installed_plugin_version($plugin_name){
        if (self::$installed_plugins === false)
            self::get_installed_plugin_inis();
        
        if (!isset(self::$installed_plugins[$plugin_name]['version']))
            return false;

        return (self::$installed_plugins[$plugin_name]['version']);
    }


    public static function get_available_plugin_versions($plugin_name){
        if (self::$available_versions === false)
            self::get_available_plugin_inis();

        if (!isset(self::$available_plugins[$plugin_name]) || !is_array(self::$available_plugins[$plugin_name]))
            return false;

        return (self::$available_plugins[$plugin_name]);
    }

    public static function get_dependencies($plugin_name, $version){
        if (self::$installed_plugins === false)
            self::get_installed_plugin_inis();
        if (self::$available_plugins === false)
            self::get_available_plugin_inis();

        if (!isset(self::$available_plugins[$plugin_name][$version]['requires']))
            return false;

        return self::$available_plugins[$plugin_name][$version]['requires'];
    }

    public static function is_upgradeable($plugin_name){
        if (self::$installed_plugins === false)
            self::get_installed_plugin_inis();
        if (self::$available_plugins === false)
            self::get_available_plugin_inis();

        if (!isset(self::$installed_plugins[$plugin_name]))
            return false;
        else if (!isset(self::$available_plugins[$plugin_name]))
            return false;
        
        $current_version = self::get_installed_plugin_version($plugin_name);
        $available_version_inis = self::get_available_plugin_versions($plugin_name);
        foreach($available_version_inis as $version=>$dont_care)
            if ($version > $current_version)
                return true;

        return false;
    }


    /**
     * Get an array where the key is the name of the plugin, and the value is an 
     * array of setting_name/setting_value pairs parsed from the plugin.ini
     *
     * @param string the path to the ini file you want to parse
     * @return array of parsed ini's
    **/
    protected static function parse_ini($ini_file_path){
        
        if (!is_file($ini_file_path))
            return false;
        
        $ini_file   = FileUtilities::get_file_contents($ini_file_path);
        $lines      = explode("\n", $ini_file);
        $inis       = array();

        foreach ($lines as $line_number=>$line){
            //remove the comments and empty whitespace padding from the line
            $line = trim(preg_replace('/\#.*$/', '', $line));

            if (!empty($line)){
                //make sure the line contains an '=' sign and that the '=' sign isn't the first letter in the string
                if (false===strpos($line, '=') || 0===strpos($line, '='))
                    die("The ini file $ini_file_path failed to parse at line $line_number. <br>the line contained:<pre>$line</pre>");
                else{
                    list($setting_name, $setting_value) = explode('=', $line, 2);
                    $setting_name = trim($setting_name);
                    $required_plugins = array();
                    if ($setting_name === 'requires'){
                        $dependencies = explode(',', $setting_value);
                        foreach ($dependencies as $dependency){
                            list($dependency_name, $dependency_version) = explode(':', $dependency, 2);
                            if (0 !== preg_match('/[^0-9a-zA-Z_]/', $dependency_name))
                                die("parse error; choked on dependency name \"$dependency_name\". The ini file $ini_file_path failed to parse at line $line_number. <br>the line contained:<pre>$line</pre>");
                            if (false === strpos($dependency_version, '.'))
                                die("parse error; choked on dependency version \"$dependency_version\". The ini file $ini_file_path failed to parse at line $line_number. <br>the line contained:<pre>$line</pre>");
                            list($major_version, $minor_version) = explode('.', $dependency_version);
                            if ($major_version=='' || $minor_version=='' || 0 != preg_match('/[^0-9]/', $major_version) || 0 != preg_match('/[^0-9]/', $minor_version))
                                die("parser error; choked on either major version \"$major_version\" ".preg_match('/[^0-9]/', $major_version)." or minor version \"$minor_version\" ".preg_match('/[^0-9]/', $minor_version).". <br>The ini file $ini_file_path failed to parse at line $line_number. <br>the line contained:<pre>$line</pre>");
                            $required_plugins[$dependency_name] = $dependency_version;
                        }
                        $setting_value = $required_plugins;
                    }
                    $inis[$setting_name] = $setting_value;
                }
            }
        }
        
        if (!isset($inis['requires']))
            $inis['requires'] = array();

        return $inis; 
    }
}
?>
