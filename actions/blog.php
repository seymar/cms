<?php

include_once './include/cms/articles.php';

$articles = new articles($database);

if(isset($_POST['delete'])) {
    if($articles->delete($_POST['id'])) {
	    define('OUTPUT_NOTICER_TEXT', 'Artikel verwijderd!');
	    define('OUTPUT_NOTICER_STATE', 'succes');
    } else {	    
	    define('OUTPUT_NOTICER_TEXT', 'error');
	    define('OUTPUT_NOTICER_STATE', 'error');
    }
}

if(isset($_POST['update'])) {
    $articles->update($_POST['id'], $_POST['title'], $_POST['body']);
    define('OUTPUT_NOTICER_TEXT', 'Artikel opgeslagen!');
    define('OUTPUT_NOTICER_STATE', 'succes');
}

if(isset($_POST['add'])) {
    $article = $articles->add();
}

if(isset($_POST['publish'])) {
	$articles->publish($_POST['id'], $_POST['state']);
    
    exit();
}

if(isset($_GET['id'])) {
    $article = $articles->get($_GET['id']);
}

include_once './include/cms/media.php';
$media = new media($database);
$media->fetch();

include_once './library/ago.function.php';