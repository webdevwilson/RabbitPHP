<?php

/**
 * $Id: Book.php 1001 2006-06-07 00:30:17Z nauhygon $
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
 * Class of a book
 * 
 * This is a test class for ezpdo
 * 
 * @author Oak Nauhygon <ezpdo4php@gmail.com>
 * @version $Revision$ $Date: 2006-06-06 20:30:17 -0400 (Tue, 06 Jun 2006) $
 * @package ezpdo_bench
 * @subpackage ezpdo_bench.books
 */
class Book extends Base {
    
    /**
     * Bool title
     * @var string
     * @orm title char(80)
     */
    public $title;
    
    /**
     * Number of pages
     * @var integer
     * @orm integer
     */
    public $pages = -1;
    
    /**
     * The authors who write the book
     * @var Author
     * @orm has many Author
     */
    public $authors = array();

    /**
     * Constructor
     * @param string
     */
    public function __construct($title = '') { 
        parent::__construct();
        $this->title = $title;
    }
    
    /**
     * Get author names
     * @return array
     */
    public function getAuthorNames() {
        $names = array();
        if ($this->authors) {
            foreach($this->authors as $author) {
                $names[] = $author->name;
            }
        }
        return $names;
    }
    
    /**
     * implement the magic function __toString()
     * @return string
     */
    public function toString() {
        $s = "book {\n";
        $s .= "  uuid: " . $this->uuid . "\n";
        $s .= "  title : " . $this->title . "\n";
        $s .= "  pages : " . $this->pages . "\n";
        $s .= "  authors: \n";
        if ($this->authors) {
            $i = 0;
            foreach($this->authors as $author) {
                $s .= "    " . ++ $i . ". " . $author->name . "\n";
            }
        } else {
            $s .= "    none\n";
        }
        $s .= "}";
        return $s;
    }
}

?>
