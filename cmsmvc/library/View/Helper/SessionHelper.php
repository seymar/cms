<?php

class SessionHelper {
	public function __construct() {
		@session_start();
	}

	public function flash() {
		if(!isset($_SESSION['flash'])) {
			return false;
		}

		$message = $_SESSION['flash'];

		// Remove flash
		$_SESSION['flash'] = '';
		unset($_SESSION['flash']);

		// Output flash template
		View::element('flash', array('message' => $message));

		return true;
	}
}