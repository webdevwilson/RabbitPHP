<h1>Controllers</h1>
<div class="documentation-quicklinks">
	<a href="#what">What are controllers?</a>
	<a href="#example">Example Controller</a>
	<a href="#lifecycle">Controller Lifecycle</a>
	<a href="#properties">Properties</a>
	<a href="#methods">Methods</a>
</div>
<a name="what"></a>
<h3>What are controllers?</h3>
<p>
	Controllers handle the business logic in your web application.  They have to extend the Controller class and are placed
	in the app/controllers directory.  The controller's name will correspond to the first parameter in the url string.  For example,
	requests to /user/login will call the login method on the UserController.  Two word url parameters separated by an underscore will
	be mapped to two worded controllers.  Example: view_user maps to ViewUserController.
</p>
<a name="example"></a>
<h3>Example Controller</h3>
<p>
 For our example, we will create a controller for our book store that will be responsible for searching books, displaying books,
 and listing books by author.  This controller is named CatalogController and must be placed in the file app/controllers/CatalogController.class.php
</p>
<div class="code">
	{literal}
	<pre>
  &lt;?php
  
  // CatalogController.class.php

  class CatalogController extends Controller {
  
    // view a book
    public function book($isbn='') {
      
      $book = find_book_by_isbn($isbn);
      
      $this->render_view('book_display');
      
      return array( 'book' => $book );
    }
    
    // search books
    public function search() {
    	
    	// get keywords from query string
    	$keywords = $this->params['keywords'];
    	
    	$books = search_books($keywords);
    	
    	$this->render_view('book_list');
    	
    	return array( 'books' => $books );
    	
    }
    
    // find books by author
    public function by_author($author_id='') {
    	
    	$books = get_books_by_author($author_id);
    	
    	$this->render_view('book_list');
    	
    	return array( 'books' => $books );
    }
    
  }
	
  ?&gt;
	</pre>
{/literal}
</div>
<p>
	As you can see, we have defined 3 methods in the CatalogController class, book, search, and by_author.  
	These correspond to the	url's (/catalog/book, /catalog/search, and /catalog/by_author) respectively.  The methods, book and
	by_author, expect a parameter (ex: /catalog/book/978-0596006815, or /catalog/by_author/4523) the other method, search, pulls
	the keywords out of the query string.
</p>
<p>We have two views being used for this controller (book_display, and book_list).
	If we wanted we could name the book_display view file as book and it would be picked up as the default view for the book action.
	But, for clarity we will leave it like it is.  The view files should be named book_display.tpl and book_list.tpl and placed
	in the app/views/catalog directory.
</p>
<a name="lifecycle"></a>
<h3>Controller Lifecycle</h3>
<p>
  <ol>
    <li>initialize()</li>
    <li>before_action()</li>
    <li>action called</li>
    <li>after_action()</li>
  </ol>
</p>
<a name="properties"></a>
<h3>Properties</h3>
<p>
  The {phpdoc_link package="RabbitPHP" subpackage="Framework" class="Controller"}Controller{/phpdoc_link} super class provides several
  properties to your controllers.
  <ul id="controller-properties-list">
		<li><span class='property'>params</span> - The request parameters ($_GET & $_POST)</li>
		<li><span class='property'>flash</span> - {phpdoc_link package="RabbitPHP" subpackage="Framework" class="Flash"}Flash{/phpdoc_link} object allows temporary persistence over redirects</li>
		<li><span class='property'>session</span> - {phpdoc_link package="RabbitPHP" subpackage="Framework" class="Session"}Session{/phpdoc_link}</li>
		<li><span class='property'>cookies</span> - {phpdoc_link package="RabbitPHP" subpackage="Framework" class="CookieCollection"}CookieCollection{/phpdoc_link}</li>
		<li><span class='property'>server</span> - Server environmental variable array ($_SERVER)</li>
		<li><span class='property'>manager</span> - {phpdoc_link package="RabbitPHP" subpackage="Framework" class="DomainObjectManager"}DomainObjectManager{/phpdoc_link} for database access</li>
		<li><span class='property'>model</span> - The model is used to access form values, model can also be accessed using property style accessors</li>
		<li><span class='property'>name</span> - The name of the controller</li>
		<li><span class='property'>plugin</span> - The plugin of the controller</li>
		<li><span class='property'>action</span> - The current action</li>
		<li style="display: none;"><span class='property'>view</span> - The view to be rendered, change to show a different view, default is current action</li>
		<li style="display: none;"><span class='property'>view_directory</span> - The directory the view will be pulled from, default is current controller name</li>
		<li><span class='property'>layout</span> - The layout to render it under, default is default.tpl</li>
		<li><span class='property'>url_components</span> - Array containing the url information</li>
		<li><span class='property'>url</span> - Current url as a string</li>
		<li><span class='property'>method</span> - The request method</li>
		<li><span class='property'>post</span> - true if current request is post</li>
		<li><span class='property'>get</span> - true if current request is get</li>
		<li><span class='property'>files</span> - Array containing the uploaded files ($_FILES)</li>
		<li><span class='property'>settings</span> - Array containing configuration settings from app/config/settings.ini</li>
		<li><span class='property'>xhr_request</span> - Is it an ajax request?</li>
		<li><span class='property'>xhr_method</span> - The ajax method (execute, update)</li>
	</ul>
</p>
<a name="methods"></a>
<h3>Methods</h3>
<p>
	{phpdoc_link package="RabbitPHP" subpackage="Framework" class="Controller"}Controller{/phpdoc_link} methods are also documented in phpdoc
	<ul id="controller-method-list">
    <li><span class='method'>initialize($name,$action,$url_components)</span> - Controller is initialized, do not override without calling parent::initialize()
    <li><span class='method'>before_action()</span> - empty method executed before the action is called, return array is put into request scope</li>
    <li><span class='method'>after_action()</span> - empty method executed after the action is called, return array is put into request scope</li>
    <li><span class='method'>send_mail($view,$model)</span> - send an email, using the passed view and model</li>
    <li><span class='method'>log_message($message)</span> - Log a message</li>
    <li><span class='method'>redirect($url,$args...)</span> - Redirect to another url or action, possible redirects(http://www.google.com, /users/register/new_user, register/new_user, new_user)</li>
    <li><span class='method'>render_element($element)</span> - Render an element</li>
    <li><span class='method'>render_view($view)</span> - Render a view</li>
  </ul>
</p>