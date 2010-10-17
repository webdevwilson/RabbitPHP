<?
/**
 * Defines abstract class base Bootstrap
 * @package RabbitPHP
 * @subpackage Framework
 * @author Matt Parker <moonmaster9000@gmail.com>
 * @version 0.1
 */

// Include EZPDO Framework and configure
require_once(RABBITPHP_HOME.'/lib/ezpdo/libs/adodb/adodb.inc.php');

/**
 * Provides base class implementation of the bootstrapper. 
 * 
 * When a plugin is installed, if a bootstrap class exists, the framework will run it's bootstrap method.
 * 
 */
abstract class Bootstrap {
	
    /**
	 * @var mixed the orm manager class
	 */
    public $manager;

	/**
	 * @var mixed the database connection in case 
	 */
    public $database;
   

    /**
	 * Initialize the class
	 */
	function __construct() {  
        // Get singleton instance of ezpdo persistence manager
        $this->manager = DomainObjectManager::instance();
        $dbconfig = new DatabaseConfiguration();
        if( $dbconfig->connection_string ) 
            $this->database = ADONewConnection($dbconfig->connection_string);

        $this->bootstrap();
    }
	
    /**
     * In this function, you'll create domain objects, populate them with default data, and save them to the database
     */
    abstract protected function bootstrap();
}
?>
