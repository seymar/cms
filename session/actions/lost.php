<?php

if(@$_POST['submit_lost']) {
	if(!$user->lost($_POST['email'])) {
		define('OUTPUT_NOTICER_STATE', 'error');
		define('OUTPUT_NOTICER_TEXT', $user->error);
	} else {
		define('OUTPUT_NOTICER_STATE', 'succes');
		define('OUTPUT_NOTICER_TEXT', 'We have send you an email!<br /><a href="../signin/">Sign in</a>');
		$disablecontent = true;
	}
}