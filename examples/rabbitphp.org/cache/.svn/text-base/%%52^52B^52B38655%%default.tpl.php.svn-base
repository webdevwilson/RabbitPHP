<?php /* Smarty version 2.6.14, created on 2007-10-11 15:23:10
         compiled from file:/home/kerrywilson/rabbitphp.org/web/view/layouts/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'not_logged_in', 'file:/home/kerrywilson/rabbitphp.org/web/view/layouts/default.tpl', 32, false),array('block', 'link', 'file:/home/kerrywilson/rabbitphp.org/web/view/layouts/default.tpl', 35, false),array('block', 'logged_in', 'file:/home/kerrywilson/rabbitphp.org/web/view/layouts/default.tpl', 39, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>RabbitPHP.org .::. PHP Rapid Web Application Development Framework - ORM, Smarty Templating</title>
    <link rel="stylesheet" type="text/css" href="/styles/utility.css" />
    <link rel="stylesheet" type="text/css" href="/styles/styles.css" />
    <style type="text/css">
    	<?php echo '
      body { margin: 0px; }
      #container { width: 950px; margin: auto; background-color: #ececec; }
      #header { height: 30px; }
      #header > #homelink { height: 180px; }
      #header > #boxes { height: 40px; }
      #header > #navigation { height: 40px; }
      #leftcolumn { float: left; width: 225px; }
      #rightcolumn { float: left; width: 725px; }
      #footer { clear: both; padding: 5px; }
      '; ?>

    </style>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <div id="homelink"><a href="/">RabbitPHP</a></div>
        <div id="navigation">
          
          <div class="clearfloat"></div>
        </div>
      </div>
      <div id="leftcolumn">
      <?php $this->_tag_stack[] = array('not_logged_in', array()); $_block_repeat=true;smarty_block_not_logged_in($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      	<div class="login box" style="display: none;">
      		<h3>Membership</h3>
      	  <?php $this->_tag_stack[] = array('link', array('module' => 'user','controller' => 'register','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>register<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	  <?php $this->_tag_stack[] = array('link', array('module' => 'user','controller' => 'login','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>login<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	</div>      
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_not_logged_in($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      <?php $this->_tag_stack[] = array('logged_in', array()); $_block_repeat=true;smarty_block_logged_in($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      	<div class="profile box">
      		<h3>User Profile</h3>
      		<?php $this->_tag_stack[] = array('link', array('module' => 'user','controller' => 'profile','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>profile<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	  <?php $this->_tag_stack[] = array('link', array('module' => 'user','controller' => 'logout','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>logout<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	</div>
      	<div class="administration box">
      		<h3>Administration</h3>
      	  <?php $this->_tag_stack[] = array('link', array('module' => 'blog','controller' => 'management','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>blog<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	  <?php $this->_tag_stack[] = array('link', array('module' => 'content','controller' => 'management','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>content<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	  <?php $this->_tag_stack[] = array('link', array('module' => 'user','controller' => 'management','action' => 'index')); $_block_repeat=true;smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>users<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_link($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      	</div>
      <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_logged_in($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
        <div class="documentation box">
      		<h3>Documentation</h3>
      		<a href="#">Installation</a>
      		<a href="#">Quick Start</a>
      		<a href="#">Controllers</a>
      		<a href="#">Domain Objects</a>
      		<a href="#">View</a>
      		<a href="#">Layouts</a>
      		<a href="#">Data Validation</a>
      		<a href="#">AJAX</a>
      		<a href="#">Plugins</a>
      	</div>
        <div class="downloads box">
      		<h3>Downloads</h3>
      		<a href="#">Latest Release</a>
      	  <a href="#">Nightly Build</a>
      	  <a href="#">Past Releases</a>
      	</div>
      	<div class="developers box">
      		<h3>Developers</h3>
      		<a href="/TODO">Todo List</a>
      		<a href="/svn">Subversion</a>
      		<a href="/docs">PHPDocs</a>
      	</div>
      </div>
      <div id="rightcolumn">
      	<div class="content">
				<?php echo $this->_tpl_vars['view']; ?>

				</div>
      </div>
      <div id="footer">
        <p>
        	Rabbitphp.org<br />
        	A Rapid PHP Web Application Development Framework
        </p>
        <div id="nav">
          <a href="/LICENSE">license</a>
          <a href="/TODO">todo</a>
          <a href="#">site map</a>
        </div>
      </div>
    </div>
    <script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
		<script type="text/javascript">
			_uacct = "UA-249405-5";
			urchinTracker();
		</script>
  </body>
</html>