<?php

define('PATH_CLIENT', (isset($_GET['id']) ? '../' : '' ) . (isset($_GET['page']) ? '../' : ''));

$dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', __FILE__);
$direx = explode('/', $dir);
$dir = str_replace($direx[sizeof($direx) - 1], '', $dir);

define('SR', $_SERVER['DOCUMENT_ROOT'] . $dir);

include_once './include/config.php';

include_once './include/database.php';

include_once './include/auth/user.php';

$user = new user($database);

if(!@$_GET['page'] || !$user->signed_in) {
    header('Location: ' . PATH_CLIENT . 'session/');
    exit();
}

/*
 * Execute actions
 */
include_once './actions/' . $_GET['page'] . '.php';