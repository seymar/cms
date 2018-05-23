<?php

# Set error reporting
//error_reporting(E_ALL);

if(file_exists(SR . 'include/config.json')) {
    $file = file_get_contents(SR . 'include/config.json');
    $config = get_object_vars(json_decode($file));
    foreach($config as $key => $value) {
        define($key, $value);
    }
} else {
    header('Location: install.php');
    exit();
}

@session_start();