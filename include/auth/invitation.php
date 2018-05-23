<?php

# Content Management System by Stijn Martens, Devcube Development
# © All rights reserved

class invitation {
	public $id;
	private $user;
	
	public function __construct($user) {
		$this->id = sha1(md5(rand()) . md5(rand()));
		$this->user = $user;
	}
	
	public function send($email) {
		$headers = "Reply-To: " . $this->user->firstname . " " . $this->user->lastname . " <" . $this->user->email . ">\n";
		
		$msg = 'Beste,'
			. "\n\n" . 'U bent uitgenodigd voor het CMS van ' . sitenaam . '.'
			. "\n\n" . 'Klik op onderstaande link om uw account te activeren:'
			. "\n" . domain . 'session/signup/' . $this->id . '/';
		
		if(!mail($email, 'Uitnodiging CMS ' . sitenaam, $msg, $headers)) {
			return false;
		}
		
		return true;
	}
}