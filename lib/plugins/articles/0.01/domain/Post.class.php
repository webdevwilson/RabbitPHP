<?php
/**
* This file defines the Post class, an ezpdo-annotated
* class for use with RabbitPHP framework
* @author Matt Parker <moonmaster9000@gmail.com>
*/

class Article extends DomainObject {

    //constraints
    public $constraints = array(
        'title' => array( 
                    'required'  => true, 
                    'unique'    => true, 
                    'max_length'=> 255,
                    'not_just_whitespace' => array(array('Post', 'not_just_whitespace'))),
        'body' => array( 
                    'required'    => true
                  ),
        'tags' => array( 
                    'required'    => true
                  ),
        'author' => array('required' => true)
        );
        
    public $messages = array(
        'title.required' => 'You must give a title to your blog posting',
        'title.not_just_whitespace' => 'Nice try! Your title must contain something other than whitespace.',
        'body.required' => 'Your blog post has no body....',
        'tags.required' => 'You didn\'t tag your post....',
        'author.required' => 'You must specify an author' 
    );

    /* @orm char(255) */
    public $title;
    
    /**
     * Constructed from the title var - basically the title var, all lowercased, 
     * stripped of special characters, and spaces turned into underscores
     * @orm char(255) 
     */
    public $prettylink;
    
    /* @orm text */
    public $body;
   
    /* @orm has one Author */
    public $author;

    /* @orm has many Tag */
    public $tags = array();
        
    //return true::boolean if there is only whitespace
    public static function not_just_whitespace($title){
      if (empty($title))
          return true; //return true here since the title.required will have already spit out an error message about the empty title
      
      $trim_title = trim($title);
      if (empty($trim_title))
        return false;
      return true;
    }
    
    //This is called right before an insert or an update
    private function make_prettylink(){
        $prettylink = trim($this->title);

        //First, remove all non alphanumeric, non whitespace characters
        $prettylink = preg_replace('/[^a-zA-Z0-9_\ ]/', '', $prettylink);
        
        //Next, replace multiple spaces with one dash
        $prettylink = preg_replace('/\s+/', '-', $prettylink);
                
        $this->prettylink = $prettylink . '--' . $this->oid;
        
    }
    
    public function on_insert($params = null){
        $this->make_prettylink();
    }
    
    public function on_update($params = null){
        $this->make_prettylink();
    }

    
    public function __toString(){
        return $this->title;
    }
    
}

?>
