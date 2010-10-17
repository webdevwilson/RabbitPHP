<h1>Domain Objects</h1>
<div class="documentation-quicklinks">
	<a href="#what">What are Domain Objects?</a>
	<a href="#object-example">Domain Object Example</a>
	<a href="#properties">Domain Object Properties</a>
	<a href="#methods">Domain Object Methods</a>
	<a href="#orm">ORM Mapping</a>
	<a href="#manager">Domain Object Manager</a>
	<a href="#manager-example">Domain Manager Example</a>
</div>
<a name="what"></a>
<h3>What are Domain Objects?</h3>
<p>
	Domain Objects are the meat &amp; potatoes of any web application.  They are the objects that are displayed by the view and manipulated
	by the controllers.  RabbitPHP makes domain object creation simple.  All you have to do is annotate a class with metadata, that describes
	it's contents and it's relationships.
</p>
<a name="object-example"></a>
<h3>Domain Object Example</h3>
<p>
  In this example, we will create a simple Book domain object for our bookstore and demonstrate some orm mapping capabilities.
</p>
<div class="code">
	{literal}
	<pre>
  &lt;?php
  
  // app/domain/Book.class.php
  class Book extends DomainObject {
	  
    /**
     * @orm char(14)
     */
    public $isbn;
		
    /**
     * @orm char(255)
     */
    public $title;
		
    /**
     * @orm clob
     */
    public $summary;
		
    /**
     * @orm datetime
     */
    public $street_date;
		
    /**
     * @orm float(2)
     */
    public $msrp;
		
    /**
     * @orm int(5)
     */
    public $pages;
		
    /**
     * @orm has one Author inverse(books)
     */
    public $author;
		
    /**
     * @orm has one Genre
     */
    public $genre;
		
    /**
     * @orm has many Book
     */
    public $related_items;
		
  }
	
  ?&gt;
	</pre>
{/literal}
</div>
<a name="properties"></a>
<h3>Domain Object Properties</h3>
<p>
  RabbitPHP's domain objects should extend the {phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject"}DomainObject{/phpdoc_link} class, 
  which provides a few default properties.
  <ul>
    <li><span class='property'>id</span> - The unique identifier for the object.</li>
    <li><span class='property'>created</span> - When the object was created.</li>
    <li><span class='property'>updated</span> - When the object was last updated.</li>
  </ul>
</p>
<a name="methods"></a>
<h3>Domain Object Methods</h3>
<p>
  {phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject"}DomainObject{/phpdoc_link} methods are also documented in phpdoc.
  <ul>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="invalid"}invalid(String $field){/phpdoc_link}</span> - Is the specified field invalid?</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="is_valid"}is_valid(){/phpdoc_link}</span> - Did the object pass validation?</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="on_create"}on_create(){/phpdoc_link}</span> - Event method called when object is created.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="on_delete"}on_delete(){/phpdoc_link}</span> - Event method called when object is deleted.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="on_insert"}on_insert(){/phpdoc_link}</span> - Event method called when object is inserted into database.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="on_load"}on_load(){/phpdoc_link}</span> - Event method called when object is loaded.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="on_update"}on_update(){/phpdoc_link}</span> - Event method called when object is updated.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="populate"}populate(Array $properties){/phpdoc_link}</span> - Populate the object with the given array key values.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="set_invalid"}set_invalid(String $property,String $constraint){/phpdoc_link}</span> - Set a property to invalid.</li>
    <li><span class='property'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObject" method="to_array"}to_array($depth=0){/phpdoc_link}</span> - Convert object to an array.</li>
  </ul>
</p>
<a name="orm"></a>
<h3>ORM Mapping</h3>
<p>
	ORM is provided by the ezpdo framework, documentation for it can be found <a href="http://ezpdo.net/blog/?p=10/">here</a>.
</p>
<a name="manager"></a>
<h3>Domain Object Manager</h3>
<p>
	The {phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObjectManager"}DomainObjectManager{/phpdoc_link} class extends
	the functionality of the ezpdo manager and creates an abstract layer between, RabbitPHP and ezpdo.  If desired, another ORM framework could be used
	by rewriting the {phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObjectManager"}DomainObjectManager{/phpdoc_link} class.
</p>
<p>
	<h4>Methods:</h4>
	<ul>
	  <li><span class='method'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObjectManager" method="commit"}commit($o...){/phpdoc_link}</span> - Save an object or objects</li>
	  <li><span class='method'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObjectManager" method="delete"}delete($o...){/phpdoc_link}</span> - Delete an object or objects</li>
	  <li><span class='method'>{phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObjectManager" method="query"}query($query){/phpdoc_link}</span> - Perform an orm specific query on the database ( ie. ezoql )</li>
	</ul>
	<h4>Dynamic Method Examples:</h4>
	<ul>
	  <li><span class='method'>get_book(1)</span> - Retrieve the book with id of 1</li>
	  <li><span class='method'>get_book_by_title('The Catcher and the Rye')</span> - Retrieve the book with the title 'The Catcher and the Rye'</li>
	  <li><span class='method'>list_book_by_author($author)</span> - Retrieve all books by the author given</li>
	  <li><span class='method'>list_book_by_author_and_year($author,1994)</span> - Retrieve all books by the author written in a certain year</li>
	  <li><span class='method'>count_book_by_author($author)</span> - How many books are written by the author?</li>
	  <li><span class='method'>delete_book()</span> - Delete all books objects</li>
	  <li><span class='method'>delete_book_by_author($author)</span> - Delete all books by an author</li>
	</ul>
	<h4>Query Options</h4>
	<p>Any method call which returns a results can add an array with the following for sorting, paging, etc...</p>
	<ul>
	  <li><span class='method'>operators</span> - An array of operators to use ( ex. &lt;, &gt;, =, like, in )</li>
	  <li><span class='method'>order</span> - array of orders ( ex. array('author asc', 'year desc' ) )</li>
	  <li><span class='method'>start</span> - row to start on ( paging )</li>
	  <li><span class='method'>max</span> - max to retrieve</li>
	</ul>
</p>
<h3>Domain Object Manager Example</h3>
<a name="manager-example"></a>
<p>
 In this example we are going to flesh out the three methods in our CatalogController and add domain object manager usage.
</p>
<div class="code">
  {literal}
  <pre>
  &lt;?php
  
  // CatalogController.class.php

  class CatalogController extends Controller {
  
    // view a book
    public function book($isbn='') {
      
      $book = $this->manager->get_book_by_isbn($isbn);
      
      $this->render_view('book_display');
      
      return array( 'book' => $book );
    }
    
    // search books
    public function search() {
      
      // get keywords from query string
      $keywords = $this->params['keywords'];
      
      $books = $this->manager->query('from Book as b where b.title like ?', $keywords);
      
      $this->render_view('book_list');
      
      return array( 'books' => $books );
      
    }
    
    // find books by author
    public function by_author($author_id='',$index=0) {
      
      $author = $this->manager->get_author($author_id);
      $books  = $this->manager->list_book_by_author($author, array( 'order' => 'title asc', 
                                                                    'index' => $index, 
                                                                    'max' => 25 ));
      
      $this->render_view('book_list');
      
      return array( 'books' => $books,
                    'author' => $author );
    }
    
  }
  
  ?&gt;
	</pre>
{/literal}
</div>