<?php

# Content Management System by Stijn Martens, Devcube Development
# © All rights reserved

class recovery {
	protected $database;
	
	public $recovery_id;
	
	public function __construct($database) {
		$this->database = $database;
		
		# Generate new recovery id
		$this->recovery_id = sha1(md5(rand()) . md5(rand()));
	}
	
	public function send($email) {
		$msg = 'Hi,'
			. "\n"
			. "\n" . 'You probably lost your password!'
			. "\n" . 'Choose a new password by clicking the link below:'
			. "\n" . 'http://devcube.nl/cms/session/recover/' . $this->recovery_id . '/'
			. "\n"
			. "\n" . 'This was an automatically generated message, so don\'t reply.'
			. "\n" . '';
		
		if(!mail($email, 'Devcube - Password recovery', $msg, 'From: Devcube <noreply@devcube.nl>') ) {
			return false;
		}
		
		return true;
	}
	
	public function validate() {
		$statement = $this->database->prepare('SELECT `id` FROM `' . db_prefix . 'users` WHERE `recovery_id` = ?');
		$statement->bind_param('s', $this->recovery_id);
		$statement->execute();
		
		$statement->store_result();
		if($statement->num_rows != 1) {
			return false;
		}
		
		return true;
	}
}