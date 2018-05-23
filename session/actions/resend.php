<?php

if(@$_POST['submit_resend']) {
	if(!$user->resend($_POST['email'])) {
		define('OUTPUT_NOTICER_STATE', 'error');
		define('OUTPUT_NOTICER_TEXT', $user->error);
	} else {
		define('OUTPUT_NOTICER_STATE', 'succes');
		define('OUTPUT_NOTICER_TEXT', 'Email verstuurd! Check je mailbox!');
		$disablecontent = true;
	}
}