<?php

if($user->type != 'admin') {
	exit('Geen toegang tot deze pagina');
}

if(isset($_POST['submit_change'])) {
	if(!$user->update_password(md5($_POST['password']), md5($_POST['password_new']), md5($_POST['password_confirm']))) {
		define('OUTPUT_NOTICER_TEXT', $user->error);
		define('OUTPUT_NOTICER_STATE', 'error');
	} else {
		define('OUTPUT_NOTICER_TEXT', 'Wachtwoord veranderd!');
		define('OUTPUT_NOTICER_STATE', 'succes');
	}
}

if(isset($_POST['submit_add'])) {
	if(!$user->invite($_POST['email'], $_POST['type'])) {
		define('OUTPUT_NOTICER_TEXT', $user->error);
		define('OUTPUT_NOTICER_STATE', 'error');
	} else {
		define('OUTPUT_NOTICER_TEXT', 'Gebruiker uitgenodigd!');
		define('OUTPUT_NOTICER_STATE', 'succes');
	}
}

if(isset($_POST['user_delete'])) {
	if($user->delete($_POST['user_id'])) {
		define('OUTPUT_NOTICER_TEXT', 'Gebruiker verwijderd!');
		define('OUTPUT_NOTICER_STATE', 'succes');
	} else {
		define('OUTPUT_NOTICER_TEXT', $user->error);
		define('OUTPUT_NOTICER_STATE', 'error');
	}
}

$users = $user->getAll();

include_once './library/ago.function.php';