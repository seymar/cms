<?php

$xdir = '../';

$dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', __FILE__);
$direx = explode('/', $dir);
    $dir = str_replace('session/' . $direx[sizeof($direx) - 1], '', $dir);

define('SR', $_SERVER['DOCUMENT_ROOT'] . $dir);
    
include_once '../include/config.php';

include_once '../include/database.php';

include_once '../include/auth/user.php';

$user = new user($database);

if($user->signed_in && $_GET['page'] != 'signup' && !isset($_GET['id'])) {
    header('Location: ../../content/');
}

if(!@$_GET['page']) {
    header('Location: signin/');
}

include_once './actions/' . $_GET['page'] . '.php';