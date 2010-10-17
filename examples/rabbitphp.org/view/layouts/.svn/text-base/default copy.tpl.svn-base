<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>RabbitPHP.org .::. PHP Rapid Web Application Development Framework - MVC, ORM, Smarty Templating, PHP On Rails</title>
    <link rel="stylesheet" type="text/css" href="/styles/utility.css" />
    <link rel="stylesheet" type="text/css" href="/styles/styles.css" />
    <style type="text/css">
    	{literal}
      body { margin: 0px; }
      #container { width: 775px; margin: auto; }
      #header { height: 60px; }
      #header > #homelink { height: 180px; }
      #header > #boxes { height: 40px; }
      #header > #navigation { height: 40px; }
      #leftcolumn { float: left; width: 200px; }
      #rightcolumn { float: left; width: 575px; }
      #footer { clear: both; padding: 5px; padding-top: 30px; }
      {/literal}
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
      {not_logged_in}
      	<div class="login box" style="display: none;">
      		<h3>Membership</h3>
      	  {link module='user' controller='register' action='index'}register{/link}
      	  {link module='user' controller='login' action='index'}login{/link}
      	</div>      
      {/not_logged_in}
      {logged_in}
      	<div class="profile box">
      		<h3>User Profile</h3>
      		{link module='user' controller='profile' action='index'}profile{/link}
      	  {link module='user' controller='logout' action='index'}logout{/link}
      	</div>
      	<div class="administration box">
      		<h3>Administration</h3>
      	  {link module='blog' controller='management' action='index'}blog{/link}
      	  {link module='content' controller='management' action='index'}content{/link}
      	  {link module='user' controller='management' action='index'}users{/link}
      	</div>
      {/logged_in}
        <div class="user_guide box">
      		<h3>User Guide</h3>
      		{link controller='pages' action='installation'}Installation{/link}
      		{link controller='pages' action='quick-start'}Quick Start{/link}
      		{link controller='pages' action='controllers'}Controllers{/link}
      		{link controller='pages' action='domain-objects'}Domain Objects{/link}
      		{link controller='pages' action='view'}View{/link}
      		{link controller='pages' action='data-validation'}Data Validation{/link}
      		{link controller='pages' action='ajax-calls'}AJAX{/link}
      		{link controller='pages' action='plugins'}Plugins{/link}
      		{link controller='pages' action='mailing'}Mailing{/link}
      		{link controller='pages' action='internationalization'}Internationalization{/link}
      	</div>
        <div class="downloads box">
      		<h3>Downloads</h3>
      		<a href="/dist/rabbitphp-0.01.tar.gz" onclick="urchinTracker('/dist/rabbitphp-latest.tar.gz')">Latest Release</a>
      	  <a href="/dist/rabbitphp-nightly.tar.gz" onclick="urchinTracker('/dist/rabbitphp-nightly.tar.gz')">Nightly Build</a>
      	  <a href="#" style="display: none;">Past Releases</a>
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
				{$view}
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