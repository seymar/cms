<?php

include_once './include/cms/media.php';
    
$media = new media($database);

if(isset($_POST['media_submit'])) {    
    if(!$media->upload($_FILES['file'])) {
        define('OUTPUT_NOTICER_TEXT', $media->error);
        define('OUTPUT_NOTICER_STATE', 'error');
    } else {
               define('OUTPUT_NOTICER_TEXT', 'Afbeelding geupload!');
        define('OUTPUT_NOTICER_STATE', 'succes');
    }
}

if(isset($_POST['media_delete'])) {
    if(!$media->delete($_POST['id'])) {
        define('OUTPUT_NOTICER_TEXT', $media->error);
        define('OUTPUT_NOTICER_STATE', 'error');
    } else {
        define('OUTPUT_NOTICER_TEXT', 'Afbeelding verwijderd!');
        define('OUTPUT_NOTICER_STATE', 'succes');
    }
}

$media->fetch();
