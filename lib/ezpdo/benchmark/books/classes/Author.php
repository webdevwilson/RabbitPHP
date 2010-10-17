<?php

/**
 * $Id: Author.php 1001 2006-06-07 00:30:17Z nauhygon $
 * 
 * Copyright(c) 2005 by Oak Nauhygon. All rights reserved.
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-06-06 20:30:17 -0400 (Tue, 06 Jun 2006) $
 * @package ezpdo_bench
 * @subpackage ezpdo_bench.books
 */

/**
 * Need Base
 */
include_once(realpath(dirname(__FILE__)).'/Base.php');

/**
 * Class of an author
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-06-06 20:30:17 -0400 (Tue, 06 Jun 2006) $
 * @package ezpdo_bench
 * @subpackage ezpdo_bench.books
 */
class Author extends Base {
    
    /**
     * Name of the author
     * @var string
     * @orm char(64)
     */
    public $name;
    
    /**
     * Books written by the author
     * @var array of Book
     * @orm has many Book
     */
    public $books = array();
    
    /**
     * Constructor
     * @param string $name author name
     */
    public function __construct($name = '') { 
        parent::__construct();
        $this->name = $name;
    }
    
    /**
     * Get the number of books the author has written
     * @return integer
     */
    public function getBookNum() {
        return count($this->books); 
    }

    /**
     * implement the magic function __toString()
     * @return string
     */
    public function toString() {
        $s = "author {\n";
        $s .= "  uuid: " . $this->uuid . "\n";
        $s .= "  name: " . $this->name . "\n";
        $s .= "  books: \n";
        if ($this->books) {
            $i = 0;
            foreach($this->books as $book) {
                $s .= "    " . ++$i . ". " . $book->title . "\n";
            }
        } else {
            $s .= "    none\n";
        }
        $s .= "}";
        return $s;
    }
}

?>
