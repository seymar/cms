<?php

include_once './include/cms/pages.php';

$pages = new pages($database);

include_once './include/cms/contents.php';

$contents = new contents($database);
    
if(isset($_POST['page_delete'])) {
    if($pages->delete($_POST['page_id'])) {
	    define('OUTPUT_NOTICER_TEXT', 'Pagina verwijderd!');
	    define('OUTPUT_NOTICER_STATE', 'succes');
    } else {	    
	    define('OUTPUT_NOTICER_TEXT', 'error');
	    define('OUTPUT_NOTICER_STATE', 'error');
    }
}

if(isset($_POST['opslaan'])) {
    $contents->update_text($_GET['id'], $_POST['text']);
    define('OUTPUT_NOTICER_TEXT', 'Content opgeslagen en gepubliceerd!');
    define('OUTPUT_NOTICER_STATE', 'succes');
}

if(isset($_POST['content_type_submit'])) {
    $contents->update_type($_GET['id'], $_POST['content_type']);
}

if(isset($_POST['content_settings_submit'])) {
    $contents->update_settings($_GET['id'], $_POST['content_settings_before'], $_POST['content_settings_after']);
}
    
if(isset($_POST['content_delete'])) {
    $contents->delete($_POST['content_id']);
}

if(isset($_POST['multiple_add'])) {
    include_once './include/cms/multiples.php';
    $multiples = new multiples($database);
    $multiples->add($_POST['multiple_content']);
}

if(isset($_POST['multiple_submit'])) {
    include_once './include/cms/multiples.php';
    $multiples = new multiples($database);
    $multiples->save($_POST['multiple_id'], $_POST['multiple_text']);
}


if(isset($_POST['multiple_delete'])) {
    include_once './include/cms/multiples.php';
    $multiples = new multiples($database);
    $multiples->delete($_POST['multiple_id']);
}

if(isset($_GET['id'])) {
    $contents->fetchById($_GET['id']);
    if($contents->fetch['type'] == 'multiple') {
        include_once './include/cms/multiples.php';

        $multiples = new multiples($database);
        $multiples->fetch($_GET['id']); 
    }
    
    include_once './include/cms/media.php';
    $media = new media($database);
    $media->fetch();
}

include_once './library/ago.function.php';