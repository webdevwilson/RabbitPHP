<?php
/**
 * This file defines the DatabaseConfiguration class, which is used to
 * configure the database connection
 *
 * @package RappitPHP_Examples
 * @subpackage Default
 * @author Kerry Wilson <kerry@rabbitphp.org>
 * @since 0.1
 */
class DatabaseConfiguration extends Configuration {
	
	protected $connection_string = 'mysql://username:password@some.host.name/databasename';
	
}
?>
