<?php
// Change "DEVELOPMENT" to "PRODUCTION" to make the debug trace at the bottom of the web pages go away
define( 'ENVIRONMENT',   'DEVELOPMENT' ); 

// This is the path to all of the core libraries used by your rabbit-php app (ezpdo, smarty, rabbitphp-core)
define('RABBITPHP_HOME', '/path/to/rabbitphp/main' );

// This is the path to your actual site or "app" 
define('APP_BASE','/path/to/your/rabbitphp/site/base/directory');

define('APP_PLUGINS', APP_BASE . '/plugins');
define('PLUGIN_REPOS', RABBITPHP_HOME . '/lib/plugin-depot');

//This kickstarts the entire page execution process
include(RABBITPHP_HOME.'/lib/framework/init.php');
?>
