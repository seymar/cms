<?php

if(@isset($_GET['id'])) {
	include_once '../include/auth/recovery.php';
	$recovery = new recovery($database);
	$recovery->recovery_id = $_GET['id'];

	if(!$recovery->validate()) {
		define('OUTPUT_NOTICER_STATE', 'error');
		define('OUTPUT_NOTICER_TEXT', 'Invalid recovery link!');
		$disablecontent = true;
	} else {
		if(@$_POST['submit_recover']) {
			if(!$user->recover(md5($_POST['password_new']), md5($_POST['password_confirm']), $_GET['id'])) {
				define('OUTPUT_NOTICER_STATE', 'error');
				define('OUTPUT_NOTICER_TEXT', $user->error);
			} else {
				define('OUTPUT_NOTICER_STATE', 'succes');
				define('OUTPUT_NOTICER_TEXT', 'Your password has been changed! <a href="../../signin/">Sign in?</a>');
				$disablecontent = true;
			}
		}
	}
} else {
	header('Location: ../');
}