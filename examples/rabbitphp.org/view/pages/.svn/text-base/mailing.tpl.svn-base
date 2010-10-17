<h1>Mailing</h1>
<div class="documentation-quicklinks">
	<a href="#overview">Mailing Overview</a>
	<a href="#configuration">Configuration</a>
	<a href="#example">A Simple Example</a>
</div>
<a name="overview"></a>
<h3>Mailing Overview</h3>
<p>
  Mailing in RabbitPHP is handled by the Mailer class, this class uses the open source mailing toolkit, PHPMailer.  
  It extends the PHPMailer class and thus it inherits all methods which it contains.  You can find examples and 
  documentation at <a href="http://phpmailer.codeworxtech.com/">http://phpmailer.codeworxtech.com</a>.  RabbitPHP
  adds some additional functionality to this class.  Model and view properties allow easy to use smarty templated
  emails.
<a name="configuration"></a>
<h3>Configuration</h3>
<p>
  Configuration is handled through the MailerConfiguration object in the config directory.  It checks for
  mailer, from, and from_name properties.
  <ul>
    <li>mailer - Method to send mail: ("mail", "sendmail", or "smtp").</li>
    <li>from - Email address of sender (no-reply@rabbitphp.org)</li>
    <li>from_name - Name of sender (rabbitphp.org mailer)</li>
  </ul>
  * At the moment only mail is implemented and it is the default
<a name="example"></a>
<h3>A Simple Example</h3>
<p>
  The following example will send an account activation email to the user.  The mailer code is located
  in the controller and the email text is in /app/mail/account_activation.tpl.  In addition, we could easily
  add multipart email by putting email text in /app/mail/account_activation.html.tpl & 
  /app/mail/account_activation.text.tpl
</p>
<p>In the controller:
<div class="code">
  {literal}
  <pre>
  &lt;?php

	$mailer = new Mailer();
	$mailer-&gt;view = 'account_activation';
	$mailer-&gt;model = array('activation_code' =&gt; 'AC234:LKJ!', 
	                          'user' =&gt; $user );
	$mailer-&gt;AddAddress($user-&gt;email_address);
	$mailer-&gt;Send();

  ?&gt;
	
	</pre>
	{/literal}
</div>
<p>In /app/mail/account_activation.tpl:
<div class="code">
  <pre>
  {literal}
 {$user.name},
	
 Welcome to the site!
	
 Your activation code is {$activation_code}
 	{/literal}
 	</pre>
</div>