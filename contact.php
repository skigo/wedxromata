<?php
/*
* Contact Form Class
*/


header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$admin_email = 'wedcolors@gmail.com'; // Your Email
$message_min_length = 5; // Min Message Length


class Contact_Form{
	function __construct($details, $email_admin, $message_min_length){
		
		$this->name = stripslashes($details['name']);
		$this->email = trim($details['email']);
		$this->tel = trim($details['tel']);
<<<<<<< HEAD
		$this->subject = "New Website Message" //trim($details['subject']); // Subject 
		$this->message ="<p><strong>Όνομα:</strong> " . stripslashes($details['name']) . "</p>" .
						"<p><strong>Email:</strong> " . trim($details['email']) . "</p>" . 
						"<p><strong>Τηλέφωνο:</strong> " . trim($details['tel']) . "</p>" .
						"<h3>Μήνυμα</h3> <p>" . stripslashes($details['message']) . "</p>";
=======
		$this->subject = trim($details['subject']); // Subject 
		$this->message = stripslashes($details['message']);
>>>>>>> parent of bb5811b... new contact
		
	
		$this->email_admin = $email_admin;
		$this->message_min_length = $message_min_length;
		
		$this->response_status = 1;
		$this->response_html = '';
	}


	private function validateEmail(){
		$regex = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
	
		if($this->email == '') { 
			return false;
		} else {
			$string = preg_replace($regex, '', $this->email);
		}
	
		return empty($string) ? true : false;
	}


	private function validateFields(){
		// Check name
		if(!$this->name)
		{
			$this->response_html .= '<div class="uk-alert uk-alert-warning">Please enter your name</div>';
			$this->response_status = 0;
		}

		// Check email
		if(!$this->email)
		{
			$this->response_html .= '<div class="uk-alert uk-alert-warning">Please enter an e-mail address</div>';
			$this->response_status = 0;
		}
		
		// Check valid email
		if($this->email && !$this->validateEmail())
		{
			$this->response_html .= '<div class="uk-alert uk-alert-warning">Please enter a valid e-mail address</div>';
			$this->response_status = 0;
		}
		
		// Check message length
		if(!$this->message || strlen($this->message) < $this->message_min_length)
		{
			$this->response_html .= '<div class="uk-alert uk-alert-warning">Please enter your message. It should have at least '.$this->message_min_length.' characters</div>';
			$this->response_status = 0;
		}
	}


	private function sendEmail(){
		$mail = mail($this->email_admin, $this->subject, $this->message,
<<<<<<< HEAD
			 "From: Website Contact <admin@wedcolors.gr>\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit"
=======
			 "From: ".$this->name." ".$this->tel." <".$this->email.">\r\n"
>>>>>>> parent of bb5811b... new contact
			."Reply-To: ".$this->email."\r\n"
		."X-Mailer: PHP/" . phpversion());
	
		if($mail)
		{
			$this->response_status = 1;
			$this->response_html = '<div class="uk-alert uk-alert-success">Thank you for contacting WedColors! Your message has been sent!</div>';
		}
	}


	function sendRequest(){
		$this->validateFields();
		if($this->response_status)
		{
			$this->sendEmail();
		}

		$response = array();
		$response['status'] = $this->response_status;	
		$response['html'] = $this->response_html;
		
		echo json_encode($response);
	}
}


$contact_form = new Contact_Form($_POST, $admin_email, $message_min_length);
$contact_form->sendRequest();

?>