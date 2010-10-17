<?php
/**
 * Defines class FileUtilities, which contains static methods to work with files
 * @package RabbitPHP
 * @subpackage Utilities
 * @author Kerry R Wilson <kerry@rabbitphp.org>, Matt Parker <moonmaster9000@gmail.com>
 * @version 0.1
 */
 
class FileUtilities {

    /**
     * recursively copy the source directory to the target directory
     */
    public static function rcopy($source, $target ){
        if (is_dir($source)){
            if (!is_dir($target))
                mkdir( $target );
            
            $source_directory = dir($source);
            while (false !== ($dir_entry = $source_directory->read())){
                if ($dir_entry != '.' && $dir_entry != '..'){
                    $dir_entry_path = $source . '/' . $dir_entry;           
                    
                    if (is_dir($dir_entry_path))
                        self::rcopy($dir_entry_path, "$target/$dir_entry");
                    else
                        copy($dir_entry_path, "$target/$dir_entry");
                }
            }
            $source_directory->close();
        }
        else
            copy($source, $target);
    }
 
  
  /**
   * get the contents of a directory in an array format
   */
  public static function get_contents($dir,$max_depth=-1) {
        
    $files = array();
    
    if( is_dir($dir) ) {
      
      if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
          
          if( is_dir( $file ) && $max_depth != 0 ) {
          	
          	$files[$file] = FileUtilities::get_contents($dir.'/'.$file,$max_depth-1);
          
          } else {
          	
          	if( $file != '.' && $file != '..' ) {
          	  $files[] = $file;
            }
          
          }
        }
        closedir($dh);
      }
    }
  
    return $files;
  
  }
  
    public static function get_directories($dir, $get_hidden=false){
        $directories = array();

        if ( is_dir($dir))
            if ($dh = opendir($dir)){
                while(($folder_entry = readdir($dh)) !== false)
                    if ( is_dir("$dir/$folder_entry") )
                        if ($get_hidden === false && $folder_entry[0] !== '.')
                            $directories[$folder_entry] = $folder_entry;
                        else if ($get_hidden === true)
                            $directories[$folder_entry] = $folder_entry;
                closedir($dh);
            }
        
        return $directories;
    }
  
  /**
   * Get the filename of a file ( i.e. /var/www/html/images/test.gif will return test.gif )
   *
   * @param $filename The path to the file
   * @param $include_extension whether to include the extension or not
   * @return filename from the given path
   */
  public static function get_filename($filepath,$include_extension=true) {
  	
  	$filename = substr( $filepath, strrpos( $filepath, '/' ) );
  	
  	if( $include_extension ) {
  		return $filename;
  	} else {
  		return substr( $filename, 0, strrpos( $filename, '.' ) );
  	}
  	
  }
  
  /**
   * Retrieve the extension of the file
   *
   * @param $file The filename to get the extension of
   * @return String the extension sans dot ( ex. jpg, gif )
   */
  public static function get_extension($filename) {
  	return substr( $filename, strrpos( $filename, '.' ) + 1 );
  }

    public static function cat_file($file_path, $file_contents){
        $directory_path = dirname($file_path);
        
        //Attempt to make the directory if it doesn't exist already
        if (!is_dir($directory_path) && !mkdir($directory_path,0757,true)){
            die("Could not make directory '$directory_path'. Check permissions and try again.");
            return false;
        }

        //attempt to open the file for writing
        $file_handle = fopen($file_path, 'w');
        if (!$file_handle){
            die("Couldn't open file '$file_path' for writing. Check permissions and try again.");
            return false;
        }

        if (false == fwrite($file_handle, $file_contents)){
            die("Error writing to file '$file_path'. Check permissions and try again.");
            return false;
        }
        fclose($file_handle);
        
        return true;
    }

    public static function get_file_contents($filepath){
        if (is_file($filepath)){
            return file_get_contents($filepath);
        }
        else
            die("'$filepath' does not exist!");
    }
  
}

?>
