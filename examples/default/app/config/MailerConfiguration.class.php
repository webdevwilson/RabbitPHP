<?php
/**
 * This file defines the MailerConfiguration class, which is used to
 * configure the application mailing
 *
 * @package RappitPHP_Examples
 * @subpackage Default
 * @author Kerry Wilson <kerry@rabbitphp.org>
 * @since 0.1
 */
 
/**
 * The database configuration class provides mailing configuration values to the application
 */
class MailerConfiguration extends Configuration {
  
  protected $mailer = 'mail';

	protected $from = 'no-reply@domain.com';
	
	protected $from_name = 'domain.com';
	
}

?>