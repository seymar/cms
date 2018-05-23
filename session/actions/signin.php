<?php

if(@$_POST['submit_signin']) {
	if(!$user->sign_in($_POST['email'], md5($_POST['password']))) {
		define('OUTPUT_NOTICER_STATE', 'error');
		define('OUTPUT_NOTICER_TEXT', $user->error);
	} else {
		header('Location: ../../');
	}
}