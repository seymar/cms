<?php

if(!$user->invitation_verify($_GET['id'])) {
	$disablecontent = true;
	define('OUTPUT_NOTICER_STATE', 'error');
	define('OUTPUT_NOTICER_TEXT', 'Ongeldige link!');
}

if(@$_POST['submit_signup']) {
	if(!$user->signup($_POST['firstname'], $_POST['lastname'], md5($_POST['password']), md5($_POST['password_confirm']))) {
		define('OUTPUT_NOTICER_STATE', 'error');
		define('OUTPUT_NOTICER_TEXT', $user->error);
	} else {
		define('OUTPUT_NOTICER_STATE', 'succes');
		define('OUTPUT_NOTICER_TEXT', 'Je account is nu actief! <a href="../../signin/">Nu inloggen?</a>');
		$disablecontent = true;
	}
}