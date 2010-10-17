<?php

/**
 * $Id: update.php 1001 2006-06-07 00:30:17Z nauhygon $
 * 
 * Copyright(c) 2005 by Oak Nauhygon. All rights reserved.
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-06-06 20:30:17 -0400 (Tue, 06 Jun 2006) $
 * @package ezpdo_bench
 * @subpackage ezpdo_bench.books
 */

include_once(dirname(__FILE__) . '/common.php');

// get the persistence manager
$m = getManager();

// create the example object to find the first author
$ea = $m->create('Author');
$ea->name = $author_name; // set name used in search
$ea->uuid = null; // null variable is ignored in searching
$ea->books = null; // null variable is ignored in searching 

// use the example object to find
if (!($authors = $m->find($ea))) {
    
    echo "Cannot find author [" . $ea->name . "]\n";
    exit();

} 

// go through each author 
foreach($authors as $author) {
    $author->uuid = $author->uuid . "(updated)";
    $author->commit();
    echo $author->uuid . "\n";
}

echo "Author [$author_name] is updated. Use `php find.php` to check.\n";
showPerfInfo();

//dumpQueries();

?>
