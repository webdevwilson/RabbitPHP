<?php /* Smarty version 2.6.14, created on 2008-02-05 09:56:58
         compiled from file:/home/kerrywilson/rabbitphp.org/examples/rabbitphp.org/view/pages/data-validation.tpl */ ?>
<h1>Data Validation</h1>
<div class="documentation-quicklinks">
	<a href="#what">What is data validation?</a>
	<a href="#example-declaration">Example Validation Declaration</a>
	<a href="#available-rules">Available Rules</a>
	<a href="#example-controller">Example Controller Validation</a>
	<a href="#messages">Messages</a>
	<a href="#messages-view">Messages View</a>
</div>
<a name="#what"></a>
<h3>What is data validation?</h3>
<p>In all applications we need to validate that what the user typed in is what we expected.  This is one
of the often overlooked aspects of an application as deadlines approach.  RabbitPHP makes data validation
simple.  It is declared in the domain object where you can simply see the properties and know what is expected of
them.
</p>
<a name="#example-declaration"></a>
<h3>Example Validation Declaration</h3>
<div class="code">
  <?php echo '
  <pre>
    // In Book.class.php
    class Book extends DomainObject {
    
    	public $constraints = array(
    	      \'isbn\' => array( \'required\' => true, 
    	                               \'unique\' => true, 
    	                               \'matches\' => \'/^[A-Za-z0-9_]+$/\' ),
  		\'title\' => array( \'required\' => true, 
  					 \'max_length\' => 255, 
  					 \'min_length\' => 5 ),
  		\'published\' => array( \'check_year\' => array(array(\'Book\',\'check_year\') ) ),
  		\'pages\' => array( \'minimum\' => 1 )
    	);
    	
    	public static function check_year($year) {
    	  return $year < date(\'Y\');
    	}
    
    }
  </pre>
  '; ?>
 
</div>
<a name="#available-rules"></a>
<h3>Available Rules</h3>
<p>
  Rules are implemented as static functions on the 
  <a href="http://rabbitphp.org/docs/RabbitPHP/Core/Validator.html">Validator</a> object.
</p>
<ul>
  <li>credit_card - validate a credit card field (true or false)</li>
  <li>custom - call a custom function (array where first element is method name, 
  and the rest are additional arguments passed after value.</li>
  <li>email - validate an email address (true or false)</li>
  <li>in_list - validate that value is on in list (array of values to compare using ==)</li>
  <li>in_range - the value needs to be in the specified range (2 element array min, max)</li>
  <li>matches - match against a regular expressing (regexpression string)</li>
  <li>maximum - field must be below a maximum number (int max value)</li>
  <li>max_length - field must be shorter than a certain length (int length)</li>
  <li>minimum - field must be above a minimum value (int)</li>
  <li>min_length - field must be longer than a certain length (int)</li>
  <li>required - field is required (true or false)</li>
  <li>unique - field must be unique, calls database to check (true or false)</li>
</ul>
<a name="#example-controller"></a>
<h3>Example Controller Validation</h3>
<div class="code">
  <?php echo '
  <pre>
  &lt;?php
  
  // BookController.class.php

  class BookController extends Controller {
  
    // create book
    public function create() {
    	
    	$book = $this->manager->create_book($this->params);
    	
    	if( $book->is_valid() && $this->manager->commit($book) ) {
    		
    		// save successful
    		
    	}
    	
    	return array( \'book\' => $book );
    	
    }
    
  }
	
  ?&gt;
  </pre>
  '; ?>

</div>
<p>
  Validation errors are display in the view files by using the validation_messages tag.
  Example: <?php echo '{validation_messages model=\'book.title\'}'; ?>

</p>
<a name="#messages"></a>
<h3>Messages</h3>
<p>
  Messages can be declared in the Domain Object.  There are sensible defaults, but it is recommended you
  use custom messages.  The defaults are defined in the Validator object.
  Validation arguments are shown in messages using $arg1, $arg2, etc...
</p>
<div class="code">
  <?php echo '
  <pre>
  // Book.class.php
  class Book extends DomainObject {
  	
  	public $messages = array(
  		\'isbn.required\' => \'ISBN is a required field, please input a valid ISBN Number.\',
  		\'title.max_length\' => \'Title too long, must be fewer than $arg1 characters.\',
  		\'published.check_year\' => \'Book has not been published yet.\' );
  }
  </pre>
  '; ?>

</div>
<a name="#messages-view"></a>
<h3>Messages View</h3>
<div class="code">
  <?php echo '
  <pre>
  &lt;-- view/book/create.tpl --&gt;
  &lt;div&gt;
    &lt;label for="book.isbn" class="{if $book-&gt;invalid(\'isbn\')}error{/if}"&gt;
      ISBN:
    &lt;/label&gt;
    {validation_messages model=\'book.isbn\'}
    {input type="text" model="book.isbn"}
  &lt;/div&gt;
  &lt;div&gt;
    &lt;label for="book.title" class="{if $book-&gt;invalid(\'title\')}error{/if}"&gt;
  	  Title:
    &lt;/label&gt;
  	{validation_messages model=\'book.title\'}
    {input type="text" model="book.title"}
  &lt;/div&gt;
  &lt;div&gt;
  	&lt;label for="book.summary" class="{if $book-&gt;invalid(\'summary\')}error{/if}"&gt;
  	  Summary:
  	&lt;/label&gt;
  	{validation_messages model=\'book.summary\'}
    {input type="textarea" model="book.summary"}
  &lt;/div&gt;
  </pre>
  '; ?>

</div>