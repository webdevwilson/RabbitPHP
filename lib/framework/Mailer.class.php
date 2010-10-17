<?php
/**
 * Defines RabbitPHP Mailer class, an extension of PHPMailer
 * @package RabbitPHP
 * @subpackage Framework
 * @author Kerry R Wilson <kerry@rabbitphp.org>
 * @version 0.1
 * @link http://phpmailer.sourceforge.net PHPMailer
 */

// Include PHPMailer framework
require_once(RABBITPHP_HOME.'/lib/phpmailer/class.phpmailer.php');

/**
 * Provides mailing capabilities to rabbitphp framework by, extending PHPMailer class<br />
 * adding view resolving and model capabilities.<br />
 * <br />
 * <b>Example Usage:</b><br />
 * $mailer = new Mailer();<br />
 * $mailer->view = 'account_activation';<br />
 * $mailer->model = array('some_obj' => $obj );<br />
 * $mailer->AddAddress('example@rabbitphp.org');<br />
 * $mailer->Send();
 * 
 * 
 * @link http://phpmailer.sourceforge.net PHPMailer
 * @todo Finish creating wrapper functions for naming convention sake
 * @todo Finish default configuration from MailerConfiguration class
 */
class Mailer extends PHPMailer {
	
	/**
	 * Constructor function calls PHPMailer Construction
	 * @todo Add mail configuration from app/config/settings.php
	 */
	public function __construct() {
		
		// in the future we will put some default configuration options here
		$config = new MailerConfiguration();
		
		// set default mailer
		if( $config->mailer ) {
			$this->Mailer = $config->mailer;
		}
		
		// set default from
		if( $config->from ) {
			$this->From = $config->from;
		}
		
		// set default from name
		if( $config->from_name ) {
			$this->FromName = $config->from_name;
		}
		
	}
	
	/**
	 * The view to render, located in app/mail
	 * @var String
	 */
	public $view;
	
	/**
	 * The model to use
	 * @var Array
	 */
	public $model;
	
	/**
	 * Send function retrieves view content and calls PHPMailer send method
	 */
	public function Send() {
		
		// get view files from the resource loader
		$view_files = ResourceLoader::instance()->get_mail_view_files($this->view);
		
		// get the rendered view
		$smarty = SmartyFactory::create();
		$smarty->assign( $this->model );
		if( is_array( $view_files ) && $view_files['html'] ) {
			
			// do multipart emails
			$html_view = $smarty->fetch($view_files['html']);
			$text_view = $smarty->fetch($view_files['text']);
			
			$this->Body = $html_view;
			$this->AltBody = $text_view;
			$this->IsHTML(true);
			
		} else {
			
			// if view files were returned, if not we go with blank body ( maybe they assigned it from the controller )
			if( $view_files ) {
			
				// convert array('html' => false, 'text' => 'APP_BASE/mail/view.text.tpl' )
				if( is_array( $view_files ) ) {
					$view_file = $view_files['text'];
				} else {
					$view_file = $view_files;
				}
			
				// fetch view
				$this->Body = $smarty->fetch($view_file);
			
			}
			
		}
		
		// call PHPMail send function
		parent::Send();
		
	}
	
	/**
	 * Set the subject of the email
	 *
	 * @param String $subject The subject
	 */
	public function set_subject($subject) {
		$this->Subject = $subject;
	}
	
	//////////////////////////////////////////////////////////////////////////////////
	// Wrapper Methods for naming conventions beyond this point
    
  /**
   * Creates message and assigns Mailer. If the message is
   * not sent successfully then it returns false.  Use the ErrorInfo
   * variable to view description of the error.
   * @return bool
   */
	//public function send() { return $this->send() }

  /**
   * Adds a "To" address.  
   * @param string $address
   * @param string $name
   * @return void
   */
	public function add_address($address) { $this->AddAddress($address); }
	
	/**
   * Adds a "Cc" address. Note: this function works
   * with the SMTP mailer on win32, not with the "mail"
   * mailer.  
   * @param string $address
   * @param string $name
   * @return void
  */
  public function add_cc($address, $name = "") { $this->AddCC($address,$name); }

    /**
     * Adds a "Bcc" address. Note: this function works
     * with the SMTP mailer on win32, not with the "mail"
     * mailer.  
     * @param string $address
     * @param string $name
     * @return void
     */
    public function add_bcc($address, $name = "") { $this->AddBCC($address,$name); }

    /**
     * Adds a "Reply-to" address.  
     * @param string $address
     * @param string $name
     * @return void
     */
    function add_reply_to($address, $name = "") { $this->AddReplyTo($address,$name); }
	
}

?>