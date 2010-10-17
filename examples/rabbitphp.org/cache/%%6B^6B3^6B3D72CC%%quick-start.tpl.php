<?php /* Smarty version 2.6.14, created on 2008-01-24 23:52:38
         compiled from file:/home/kerrywilson/rabbitphp.org/examples/rabbitphp.org/view/pages/quick-start.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'phpdoc_link', 'file:/home/kerrywilson/rabbitphp.org/examples/rabbitphp.org/view/pages/quick-start.tpl', 128, false),)), $this); ?>
<h1>Quick Start</h1>
<div class="documentation-quicklinks">
	<a href="#hello-world">Hello World!</a>
	<a href="#naming">Naming Conventions</a>
	<a href="#app-structure">Application Structure</a>
</div>
<a name="hello-world"></a>
<h3>Hello World!</h3>
<p>
	First, we will start our hello world with a simple controller method call.  The url to /hello/world will call the world method
	on the HelloController class.  So in /app/controllers/HelloController.class.php we put the following code: 
</p>
<div class="code">
	<?php echo '
	<pre>
  &lt;?php
  
  // HelloController.class.php

  class HelloController extends Controller {
  
    public function world() {
      $this->view = \'sayit\';
      return array( \'who\' => \'World\' );
    }
    
  }
	
  ?&gt;
	</pre>
	'; ?>

</div>
<p>
  As you can see we set the view file name, then return who to say hello to.  This is, in turn, is put into
  request scope as a smarty template variable.  We can now use it in the file /app/views/hello/sayit.tpl.
</p>
<div class="code">
	<?php echo '
	<pre>
  &lt;p&gt;Hello {$who}!&lt;/p&gt;
	</pre>
	'; ?>

</div>
<p>
  Now, suppose we want to pass a parameter in as who we want to say hello to.
</p>
<div class="code">
	<?php echo '
	<pre>
  &lt;?php
  
  // HelloController.class.php

  class HelloController extends Controller {
    
    public function sayit($who=\'\') {
      return array( \'who\' => $who );
    }
    
  }
	
  ?&gt;
	</pre>
	'; ?>

</div>
<p>
  A call to /hello/sayit/example will output 'Hello example!'.  As you can see, we did not explicitly set the name
  of the view file.  That is because it defaults to the action name.  Simple, right?  We always need to put a default 
  value on the parameters in an action method so that we don't get an ugly message when it is not specified.
</p>
<p>
  Next, we might want to pull the name from a database.  So, we are going to setup an <a href="http://ezpdo.net">ezpdo</a> annotated User class that will only
  contain a username (max 50 chars) and full_name (max 75 chars).  In /app/domain/User.class.php we put the following
</p>
<div class="code">
	<?php echo '
	<pre>
  &lt;?php
  
  class User extends DomainObject {
    
    /**
     * @orm char(50)
     */
    public $username;
    
    /**
     * @orm char(75)
     */
    public $full_name;
    
  }
	
  ?&gt;
	</pre>
	'; ?>

</div>
<p>
  Assuming we have a database chock full of people, we can print someone's name be accessing the url /hello/user/username by
  putting the following action method in the controller.
</p>
<div class="code">
	<?php echo '
	<pre>
  &lt;?php
  
  // HelloController.class.php

  class HelloController extends Controller {
  
    public function user($username=\'\') {
      
      $this->view = \'sayit\';
      
      $user = $this->manager->get_user_by_username($username);
      $who = $user->full_name;
      
      return array( \'who\' => $who );
    }
    
  }
	
  ?&gt;
	</pre>
	'; ?>

</div>
<p>
  We are using the <?php $this->_tag_stack[] = array('phpdoc_link', array('package' => 'RabbitPHP','subpackage' => 'Framework','class' => 'DomainObjectManager')); $_block_repeat=true;smarty_block_phpdoc_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>DomainObjectManager<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_phpdoc_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  to retrieve the user from the database.  Then we are returning the user's full name to be displayed in the view.
</p>
<a name="naming"></a>
<h3>Naming Conventions</h3>
<p>
	<ul>
	  <li>Class names should be camel-cased.</li>
  	<li>Classes are loaded from files that are named Classname.class.php, these files are expected to contain
  	only the class definition of the class that it is named after.  However, they can contain additional classes
  	assuming they are only used inside of that class or are never accessed without that class (ex: Factory design pattern).</li>
  	<li>Controller methods should be lower cased with all words separated with an underscore (_) character.</li>
  </ul>
</p>
<a name="app-structure"></a>
<h3>Application Structure</h3>
<p>
  <ul id="application-structure">
    <li>/app/cache - used by framework for caching, should be writable by web server.</li>
    <li>/app/classes - contains utility classes</li>
    <li>/app/config - configuration settings files belong in here</li>
    <li>/app/controllers - contains the controller classes</li>
    <li>/app/domain - domain objects be here</li>
    <li>/app/logs - Log file directory
    <li>/app/plugins - directory for all your plugins</li>
    <li>/app/tags - Smarty tag files should be placed in this directory</li>
    <li>/app/views - controller view files are under the controller name in this directory</li>
    <li>/app/views/layouts - layouts go in here</li>
    <li>/app/views/elements - place for your reusable view elements</li>
    <li>/app/webroot - Apache document root should point here, or use mod_rewrite</li>
  </ul>
</p>
  