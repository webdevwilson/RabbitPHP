<h1>Ajax Calls</h1>
<div class="documentation-quicklinks">
	<a href="#rabbitphp-remote">RabbitPHP Remote Javascript Library</a>
	<a href="#execute-method">Execute Method</a>
	<a href="#update-method">Update Method</a>
</div>
<a name="rabbitphp-remote"></a>
<h3>RabbitPHP Remote Javascript Library</h3>
<p>
  AJAX method calls in RabbitPHP are provided by the RabbitPHP Remote javascript class.  This class requires prototype, and contains two methods, Execute and Update.
  Execute methods pass an object to the callback function.  Update method calls update an HTML element with the rendered output.
<a name="execute-method"></a>
<h3>Execute Method</h3>
<p>
	The execute method could be used by our bookstore to retrieve a book data object for a quick lookup: 
</p>
<div class="code">
	{literal}
	<pre>
  &lt;?php
  
  // BookController.class.php

  class BookController extends Controller {
  
    protected $remote_methods = array('lookup');
    
    public function lookup($isbn=false) {
    	return $this->manager->get_book_by_isbn($isbn);
    }
    
  }
	
  ?&gt;
  </pre>
  {/literal}
</div>
<p>
	The remote_methods properties declares a method as available to ajax calls.  The lookup function is a normal controller method, whatever is
	returned is converted to json and automatically evaluated.
</p>
<div class="code">
	{literal}
	<pre>
  &lt;-- view.tpl --&gt;
  &lt;script type="text/javascript"&gt;
  
    Event.observe('lookup','click', function() {
      
      var isbn = $('isbn').value;
      var opts = { method: 'GET' }
      Remote.execute('/book/lookup/'+isbn, function(book) { 
      	alert('Title: '+book.title);
      }, opts);
      
    });
  
  &lt;/script&gt;
  
  &lt;div&gt;
    &lt;input type='text' id='isbn' value='' /&gt;
    &lt;input type='button' id='lookup' value='lookup' /&gt;
  &lt;/div&gt;
  
	</pre>
	{/literal}
</div>
<p>
  When the lookup button is clicked, the ajax method calls the uri /book/lookup/1.  This calls the lookup method on the book controller, and passes the returned
  model to the javascript callback function.
</p>
<a name="update-method"></a>
<h3>Update Method</h3>
<p>
	The update method is used to update an html element with content from the controller.  For example, we could render
	a view of a book using the following.
</p>
<div class="code">
	{literal}
	<pre>
  &lt;?php
  
  // BookController.class.php

  class BookController extends Controller {
  
    protected $remote_methods = array('show');
    
    public function show($isbn=false) {
    	return array('book' => $this->manager->get_book_by_isbn($isbn));
    }
    
  }
	
  ?&gt;
  
  {* show.tpl *}
  &lt;div class="book"&gt;
    &lt;h1&gt;{$book.title}&lt;/h1&gt;
    &lt;p&gt;{$book.description}&lt;/p&gt;
  &lt;/div&gt;
  
  </pre>
  {/literal}
</div>
<p>
	The show method behaves like a normal controller action method.  However, when the action is called from ajax, by default, the template is not
	rendered.   You can show the template by setting the layout property ($this->layout = 'default').
</p>
<div class="code">
	{literal}
	<pre>
  &lt;-- view.tpl --&gt;
  &lt;script type="text/javascript"&gt;
  
    Event.observe('show','click', function() {
      
      var isbn = $('isbn').value;
      var opts = { method: 'GET' }
      Remote.update($('display'), '/books/show/'+isbn, opts );
      
    });
  
  &lt;/script&gt;
  
  &lt;div&gt;
    &lt;input type='text' id='isbn' value='' /&gt;
    &lt;input type='button' id='show' value='show' /&gt;
    &lt;div id='display'&gt;&lt;/div&gt;
  &lt;/div&gt;
  
	</pre>
	{/literal}
</div>
<p>
  The above code will show the results of the show method on the book controller in the display div.
</p>