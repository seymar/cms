<?php

# By @Stijntjhe

class activation {
	private $id;
	
	public __construct() {
		$this->id = sha1(md5(rand()) . md5(rand()));
	}
	
	public function send($email) {
		
		$msg = 'Beste,'
			. "\n\n"
			. "\n" . 'Klik op onderstaande link om uw account te activeren.'
			. "\n" . domain . 'session/activate/' . $this->id . '/'
			. "\n"
			. "\n" . 'CMS ' . sitenaam;
		
		if(!mail($email, 'Account activeren', $msg, 'From: CMS ' . sitenaam . ' <noreply@' . $_SERVER['SERVER_NAME'] . '>') ) {
			return false;
		}
		
		return true;
	}
}