<?php

if($_GET['page'] == 'activate' AND isset($_GET['id'])) {
	$disablecontent = true;
	if(!$user->activate($_GET['id'])) {
		define('OUTPUT_NOTICER_STATE', 'error');	
		define('OUTPUT_NOTICER_TEXT', $user->error);	
	} else {
		define('OUTPUT_NOTICER_STATE', 'succes');	
		define('OUTPUT_NOTICER_TEXT', 'Email geverifieerd! <a href="../../signin/">Log in!</a>');
	}
}