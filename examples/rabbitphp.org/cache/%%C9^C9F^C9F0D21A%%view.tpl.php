<?php /* Smarty version 2.6.14, created on 2008-02-04 23:17:13
         compiled from file:/home/kerrywilson/rabbitphp.org/examples/rabbitphp.org/view/pages/view.tpl */ ?>
<h1>View</h1>
<div class="documentation-quicklinks">
	<a href="#what">What is the view?</a>
	<a href="#example-view">Example View File</a>
	<a href="#layouts">Layouts</a>
	<a href="#example-layout">Example Layout File</a>
	<a href="#elements">Elements</a>
	<a href="#example-element">Example Element</a>
	<a href="#included-elements">Included Elements</a>
</div>
<h3>What is the view?</h3>
<p>
  The view tier in a RabbitPHP application consists of 3 different concepts, layouts, view files, and elements.
  Layouts are the general design for the website, they wrap the view file output.  Layout files required the tag <?php echo '{$view}'; ?>

  to be placed where the view file should be rendered.  Elements are reusable components that can be rendered using the
  render tag.  All view files are smarty templates and have access to smarty variables.
</p>
<a name="#example-view"></a>
<h3>Example View File</h3>
<p>
	Our example view file will be the book display (book_display.tpl).
</p>
<div class="code">
<?php echo '
 <pre>
   &lt;h1&gt;{$book.title}&lt;/h1&gt;
   &lt;p&gt;By: {$book.author.name}&lt;/p&gt;
   &lt;p&gt;{$book.description}&lt;/p&gt;
   &lt;p&gt;Info:&lt;/p&gt;
   Pages: {$book.pages}&lt;br /&gt;
   Released: {$book.street_date|date_format}&lt;br/&gt;
   ISBN: {$book.isbn}
 </pre>
'; ?>

</div>
<p>
  This view file is a standard smarty template referencing the book variable returned by our CatalogController in the previous
  example.  You can find smarty documentation <a href="http://smarty.php.net">here</a>.  date_format is a standard smarty modifier.
</p>
<a name="#layouts"></a>
<h3>Layouts</h3>
<p>
  Layouts are the files that govern the overall look and feel for your website.  These reside in the app/view/layouts directory.  The
  default layout file is default.tpl, but this can be changed in the controller by changing the $this->layout property.
</p>
<a name="#example-layout"></a>
<h3>Example Layout</h3>
<p>
  Our example layout file, will be for our Bookstore and will briefly demonstrate what it should look like.
</p>
<div class="code">
<?php echo '
 <pre>
   &lt;-- view/layouts/default.tpl --&gt;
   &lt;html&gt;
     &lt;head&gt;
       &lt;title&gt;Bookstore Demo - {$page_title}&lt;/title&gt;
     &lt;/head&gt;
     &lt;body&gt;
       &lt;div class="nav"&gt;
         &lt;a href="/catalog/genre/mystery"&gt;Mystery&lt;/a&gt;
         &lt;a href="/catalog/genre/romance"&gt;Romance&lt;/a&gt; 
         &lt;a href="/catalog/genre/suspense"&gt;Suspense&lt;/a&gt;
       &lt;/div&gt;
       {$view}
     &lt;/body&gt;
   &lt;/html&gt;
 </pre>
'; ?>

</div>
<p>
  This layout file is pretty straight-forward, with a title and main navigation.  The view file will be rendered where the
  <?php echo $this->_tpl_vars['view']; ?>
 tag appears.  Also, other smarty variables are available as you can see the page_title could be returned from the
  controller also, or maybe returned from a before_action interceptor.
</p>
<a name="#elements"></a>
<h3>Elements</h3>
<p>
  Elements are reusable view files that are placed in the app/view/elements directory and rendered with the <?php echo '{render}'; ?>
 tag.
  In the above example the navigation could have been made into an element.
</p>
<a name="#example-element"></a>
<h3>Example Element</h3>
<p>
  Our example element will be the navigation of the above site, that will allow us to include it in multiple
  layouts.
</p>
<div class="code">
<?php echo '
 <pre>
   &lt;-- view/elements/navigation.tpl --&gt;
   &lt;div class="nav"&gt;
     {foreach from=$genres item=\'genre\'}
     &lt;a href="/catalog/genre/{$genre.stub}"&gt;{$genre.title}&lt;/a&gt;
     {/foreach}
   &lt;/div&gt;
   
   &lt;-- view/layouts/default.tpl --&gt;
   &lt;html&gt;
     &lt;head&gt;
       &lt;title&gt;Bookstore Demo - {$page_title}&lt;/title&gt;
     &lt;/head&gt;
     &lt;body&gt;
       {render element=&quot;navigation&quot;}
       {$view}
     &lt;/body&gt;
   &lt;/html&gt;
 </pre>
'; ?>

</div>
<p>
   In this example, genres can be an array passed from the controller or we could pass it in the render tag
   like, genres=$genre_list, where genre_list is a value returned from the controller.
</p>
<a name="#included-elements"></a>
<h3>Included Elements</h3>
<p>
	There are a few elements included with the rabbitphp framework.  These are located in the
	RABBITPHP_HOME/lib/framework/elements directory, and can be viewed for usage.
</p>
<ul>
  <li>confirm - used for confirmation dialogs</li>
  <li>messages - displays flash message, error, and warning messages</li>
  <li>redirect - do a delayed browser redirect</li>
  <li>validation_messages - used to display validation messages</li>
  <li>view_file_missing - text displayed when view file is missing</li>
</ul>
  
  