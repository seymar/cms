<?php 

if(isset($_POST['submit_change'])) {
	if(!$user->update_password(md5($_POST['password']), md5($_POST['password_new']), md5($_POST['password_confirm']))) {
		define('OUTPUT_NOTICER_TEXT', $user->error);
		define('OUTPUT_NOTICER_STATE', 'error');
	} else {
		define('OUTPUT_NOTICER_TEXT', 'Wachtwoord veranderd!');
		define('OUTPUT_NOTICER_STATE', 'succes');
	}
}