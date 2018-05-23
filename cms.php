<?php

/*
** CMS Stijn Martens @Stijntjhe
**
** Enable CMS on your page by including this file at the beginning of your page with a code similar to this:
**
** <?php include_once 'cms/cms.php'; ?>
**
** (Assuming the CMS is installed in the directory called "cms" and the page you want to enable the CMS on is in the same directory, otherwise change the path.)
** Don't forget to rename the extention of your page from ".html" to ".php" if not done already.
**
** To add dynamic content to your page use this code:
**
** <?php $cms->content('Content name'); ?>
**
** (Replace "Content name" with something else, has to be unique per page.)
** 
** If you include your pages, and use one main index.php.
** Or you want a custom name shown in the CMS admin panel.
** Use this code on each page:
** 
** <?php $cms->page('Page name');
**
** (Replace "Page name" with the name for the page you want.)
*/

error_reporting(E_ALL);

$dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', __FILE__);
$direx = explode('/', $dir);
$dir = str_replace($direx[sizeof($direx) - 1], '', $dir);

define('SR', $_SERVER['DOCUMENT_ROOT'] . $dir);

include_once SR . 'include/config.php';

include_once SR . 'include/database.php';

include_once SR . 'include/cms/cms.php';

$cms = new cms($database);