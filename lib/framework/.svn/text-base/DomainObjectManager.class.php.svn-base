<?php
/**
 * Defines DomainObjectManager class, the interface for DomainObject management
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 */
 
/**
 * DomainObjectManager provides a common interface for domain object management.  All ezpdo
 * code resides in this class, such that switching to a different ORM framework will only require
 * the DomainObjectManager class to be rewritten ( as long as RabbitPHP conventions are followed ).
 * 
 * <b>Notable Methods:</b><br />
 * commit - Save an object<br />
 * delete - Delete an object<br />
 * query - Perform an orm specific query on the database ( ie. ezoql )<br />
 * _call - The most widely used method of this class provides dynamic calling of object retrieval methods<br />
 *
 * <b>Dynamic Method Examples:</b><br />
 * get_book(1) - Retrieve the book with id of 1<br />
 * get_book_by_title('The Catcher and the Rye') - Retrieve the book with the title 'The Catcher and the Rye'<br />
 * list_book_by_author($author) - Retrieve all books by the author given<br />
 * list_book_by_author_and_year($author,1994) - Retrieve all books by the author written in the year<br />
 * count_book_by_author($author) - How many books are written by the author?<br />
 * delete_book() - Delete all books objects<br />
 * delete_book_by_author($author) - Delete all books by an author<br />
 * 
 * <b>Query Options</b><br />
 * Any method call which returns a results can add an array with the following for sorting, paging, etc...
 *
 * operators - An array of operators to use ( ex. <, >, =, like, in )<br />
 * order - array of orders ( ex. array('author asc', 'year desc' ) )<br />
 * start - row to start on ( paging )<br />
 * max   - max to retrieve<br />
 * 
 * @link http://ezpdo.net
 */
class DomainObjectManager {
  
  private static $instance;
  private $manager;
  
  /**
   * Private constructor function facilitates singleton pattern
   */
  private function DomainObjectManager() {
  	
  	// Include EZPDO Framework and configure
    require_once(RABBITPHP_HOME.'/lib/ezpdo/ezpdo_runtime.php');
    
    $db = new DatabaseConfiguration();
    
    $cfg = array('default_oid_column' => 'id',
                 'default_dsn'  => $db->connection_string,
                 'source_dirs'  => APP_BASE.'/domain,'.RABBITPHP_HOME.'/lib/framework,'.APP_BASE.'/plugins',
                 'recursive'    => true,
                 'compiled_dir' => APP_BASE.'/cache',
                 'force_compile'=> ( ENVIRONMENT == 'DEVELOPMENT' ),
                 'auto_compile' => ( ENVIRONMENT == 'DEVELOPMENT' ),
                 'check_table_exists' => ( ENVIRONMENT == 'DEVELOPMENT' ),
                 'backup_compiled' => false, //( ENVIRONMENT == 'DEVELOPMENT' ),
                 'auto_flush' 	=> false,
                 'flush_before_find' => false,
                 'db_lib'       => 'adodb',
                 'table_prefix' => '',
                 'relation_table' => 'relation_',
                 'split_relation_table' => true,
                 'check_table_exists' => ( ENVIRONMENT == 'DEVELOPMENT' ),
                 'autoload' => false,
                 'log_console'  => false,
                 'dispatch_events' => true,
                 'log_file'     => APP_BASE.'/logs/ezpdo/'.date('m-d-Y').'.log');
    epManager::instance()->setConfig($cfg);
    error_reporting(E_ALL ^ E_NOTICE);
    
    $this->manager = epManager::instance();
  }
  
  /**
   * Retrieve the instance of DomainObjectManager
   *
   * @return DomainObjectManager instance
   */
  public static function instance() {
  	
  	if(! DomainObjectManager::$instance ) {
  		DomainObjectManager::$instance = new DomainObjectManager();
  		DomainObjectManager::$instance->manager->register(DomainObjectManager::$instance);
    }
  	
  	return DomainObjectManager::$instance;
  }
  
  /**
   * Query the domain object manager
   *
   * @param string $query The query to execute
   * @return mixed results of the query
   */
  public function query() {
  	
  	$function = array($this->manager, 'find');
		$args = func_get_args();
   	return call_user_func_array($function, $args);
  	
  	// Build the arguments
  	/*
  	$args = func_get_args();
  	$func_args = '';
    for( $i = 0; $i < count( $args ); $i++ ) {
      $func_args .= '$args['.$i.'],';
    }
    $func_args = substr( $func_args, 0, -1 );
  	
  	$returner = false;
  	$php = '$returner = $this->manager->find('.$func_args.');';
  	
  	eval( $php );
  	return $returner;*/
  }
  
  /**
   * Commit an object to persistent storage
   *
   * @param mixed objects to be committed
   * @return bool true if all successful, false otherwise
   */
  public function commit() {
  	
  	$args = func_get_args();
  	$returner = true;
  	
  	// loop through arguments and commit
  	foreach( $args AS $obj ) {
  	  $returner = ( $this->manager->commit($obj,false) && $returner );
  	}
  	
  	return $returner;
  }
  
  /**
   * Delete an object
   *
   * @param mixed objects to be deleted
   * @return bool true if all successful, false otherwise
   */
  public function delete() {
  	
  	$args = func_get_args();
  	$returner = true;
  	
  	// loop through arguments and commit
  	foreach( $args AS $obj ) {
  		$this->manager->delete( $obj );
  	  $returner = ( $this->manager->commit($obj,false) && $returner );
  	}
  	
  	return $returner;
  }
  
	/**
	 * Handle calls to undefined methods, defines the domain object retrieval methods:
	 *
	 * Examples:
	 * get_book(1) - Retrieve the book with id of 1
	 * get_book_by_title('The Catcher and the Rye') - Retrieve the book with the title 'The Catcher and the Rye'
	 * list_book_by_author($author) - Retrieve all books by the author given
	 * list_book_by_author_and_year($author,1994) - Retrieve all books by the author written in the year
	 * count_book_by_author($author) - How many books are written by the author?
	 * delete_book() - Delete all books objects
	 * delete_book_by_author($author) - Delete all books by an author
	 * 
	 * Options Available:
	 * operators - An array of operators to use ( ex. <, >, =, like, in )
	 * order - array of orders ( ex. array('author asc', 'year desc' ) )
	 * start - row to start on ( paging )
	 * max   - max to retrieve
	 * 
	 * @param string $method The method name
	 * @param mixed $args The method arguments
	 */
	public function __call($method,$args) {
    
    $method_parts = explode('_',$method);
    
    if( in_array( $method_parts[0], array( 'create', 'get', 'list', 'count', 'delete' ) ) ) {
    	
    	$ezpdo_method = array_shift( $method_parts );
    	
    	$domain_object = array_shift( $method_parts );
    	while( $method_parts[0] && $method_parts[0] != 'by' ) {
    	  $domain_object .= ' '.array_shift( $method_parts );
    	}
    	$domain_object = str_replace(' ','',ucwords($domain_object));
    	
    	$current_column_index=0;
    	$columns = array();
    	if( array_shift($method_parts) == 'by' ) {
    		while( count( $method_parts ) > 0 ) {
    		  $element = array_shift($method_parts);
    		  if( $element == 'and' ) {
    		    $columns[$current_column_index] = implode( '_', $current_column );
    		    $current_column_index++;
    		    $current_column=array();
    		  } else {
    		    $current_column[] = $element;
    		  }
    		}
    		$columns[$current_column_index] = implode( '_', $current_column );
    	}
    	
    	if( $ezpdo_method == 'create' ) {
    	 
    	  $constructor_args = ',';
    	  for( $i = 0; $i < count( $args ); $i++ ) {
    	  	$constructor_args .= '$args['.$i.'],';
    	  }
    	  $constructor_args = substr( $constructor_args, 0, -1 );
    	  $returner = false;
    	  
    	  eval( '$returner = $this->manager->create($domain_object'.$constructor_args.');' );
    	  
    	  return $returner;
    	
    	} else if( $ezpdo_method == 'get' && count($columns) == 0 ) {
    		
    		// Do get by id
    		if( intval($args[0]) == 0 ) return false;
    		return $this->manager->get($domain_object,intval($args[0]));	
    	
    	} else if( $ezpdo_method == 'list' && count($columns) == 0 ) {
    		
    		$options = $args[0];
    		if( is_array( $options ) ) {
    			
    			$ezoql = 'from '.$domain_object.' ';
    			
    			// Build order clause
    			if( $options['order'] ) {
    				if( !is_array( $options['order'] ) ) {
    					$options['order'] = array( $options['order'] );
    				}
    				$ezoql .= ' order by '. implode(', ',$options['order']);
    			}
    		
    			// Build limit clause
    			if( $options['start'] && $options['max'] ) {
    				$ezoql .= ' limit '.$options['start'].','.$options['max'];
    			} else if ( $options['start'] ) {
    				$ezoql .= ' limit ' . $options['start'] . ', 99999';
    			} else if ( $options['max'] ) {
    				$ezoql .= ' limit ' . $options['max'];
    			}
    			
    			return $this->manager->find($ezoql);
    			
    		} else {
    			// do list all
    			return $this->manager->get($domain_object);
    		}
    		
    	} else if ( $ezpdo_method == 'delete' && count($columns) == 0 ) {
    		
    		return $this->manager->deleteAll($domain_object);
    		
    	} else {
    	
    	  // Build ezoql query
    	  if( $ezpdo_method == 'count' ) {
    	    $ezoql = 'count(*) from '.$domain_object.' as '.strtolower($domain_object{0}).' where ';
    		} else {
    	  	$ezoql = 'from '.$domain_object.' as '.strtolower($domain_object{0}).' where ';
    		}
    	  
    	  $options = $args[count($columns)];
    	  
    	  $arguments = '';
    		$index=0;
    		foreach( $columns AS $column ) {
    			
    			if( !is_array( $options['operators'] ) ) {
    				$options['operators'] = array( $options['operators'] );
    			}
    			
    			// Determine operators
    			if( $options['operators'][$index] ) {
    				$operator = $options['operators'][$index];
    			} else {
    				$operator = '=';
    			}
    			
    			$ezoql .= strtolower($domain_object{0}).'.'.$column.' '.$operator.' ? and ';
    			$arguments .= '$args['.$index++.'],';
    		}
    		$ezoql = substr($ezoql,0,-5);
    		
    		// Build order clause
    		if( $options['order'] ) {
    			if( !is_array( $options['order'] ) ) {
    				$options['order'] = array( $options['order'] );
    			}
    			$ezoql .= ' order by '. implode(', ',$options['order']);
    		}
    		
    		// Build limit clause
    		if( $options['start'] && $options['max'] ) {
    			$ezoql .= ' limit '.$options['start'].','.$options['max'];
    		} else if ( $options['start'] ) {
    			$ezoql .= ' limit ' . $options['start'] . ', 99999';
    		} else if ( $options['max'] ) {
    			$ezoql .= ' limit ' . $options['max'];
    		}
    		
    		$arguments = substr($arguments,0,-1);
        
        $code = '$returner = $this->manager->find($ezoql';
        if( $arguments != '' ) {
        	$code .= ','.$arguments;
        }
        $code .= ');';
        
        eval( $code );
    		
    		// If get call only return first domain object
    		if( $ezpdo_method == 'get' ) {
    			return $returner[0];
    		} else if ( $ezpdo_method == 'delete' ) {
    			$this->delete($returner);
    		} else {
    			return $returner;
    		}
    	}
    	
    } else {
    	
    	// method not found
    	throw new Exception('Method \''.$method.'\' not implemented by DomainObjectManager');
    
    }
  }
  
  /////////////////////////////////////////////////////////////////////////////////////////////
  // DOMAIN OBJECT LISTENER METHODS
  
  /**
   * onCreate method calls the on create event on the object
   */
  public function onCreate(epObject $o, $params = null) {
  	$o->on_create();
  }
  
  /**
   * onLoad method adds the oid to the id field
   */
  public function onLoad(epObject $o, $params = null) {
    $o->id = $o->oid;
    $o->on_load();
  }
    
  /**
   * onPreInsert - event called by ezpdo before inserting object into database
   * DomainObject uses it to setup created and updated times
   */
  public function onPreInsert(epObject $o, $params = null) {
    $o->created = mktime();
    $o->updated = mktime();
    $o->on_insert();
  }
  
  /**
   * onPreUpdate - event called by ezpdo before inserting object into database
   * DomainObject uses it to setup created and updated times
   */
  public function onPreUpdate(epObject $o, $params = null) {
    $o->updated = mktime();
    $o->on_update();
  }
  
  /**
   * onPreDelete - event called by ezpdo before deleting an object from the database
   */
  public function onPreDelete(epObject $o, $params = null) {
  	$o->on_delete();
  }
  
}

?>