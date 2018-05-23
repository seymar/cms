<?php

$error = false;

if(isset($_POST['submit'])) {
    if(empty($_POST['sitenaam']) || empty($_POST['db_host']) || empty($_POST['db_database']) || empty($_POST['db_username']) || empty($_POST['db_password']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error = 'Vul alle velden in a.u.b.';
    } else {
        if(!$db = mysql_connect($_POST['db_host'], $_POST['db_username'], $_POST['db_password'])) {
            $error = 'Kon niet verbinden met de MySQL database.';
        } else {
            if(!mysql_select_db($_POST['db_database'])) {
                $error = 'Kon niet verbinden met de MySQL database.';
            } else {
                if(!mysql_query("CREATE TABLE IF NOT EXISTS `" . $_POST['db_prefix'] . "contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` enum('single','multiple') NOT NULL DEFAULT 'single',
  `text` text NOT NULL,
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `incode` enum('true','false') NOT NULL DEFAULT 'true',
  `before` varchar(255) NOT NULL DEFAULT '',
  `after` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
") || !mysql_query("
CREATE TABLE IF NOT EXISTS `" . $_POST['db_prefix'] . "multiples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
") || !mysql_query("
CREATE TABLE IF NOT EXISTS `" . $_POST['db_prefix'] . "pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `incode` enum('true','false') NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`),
  UNIQUE KEY `file` (`file`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
") || !mysql_query("
CREATE TABLE IF NOT EXISTS `" . $_POST['db_prefix'] . "uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `ext` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
") || !mysql_query("
CREATE TABLE IF NOT EXISTS `" . $_POST['db_prefix'] . "users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `firstname` varchar(255) NOT NULL DEFAULT '',
  `lastname` varchar(255) NOT NULL DEFAULT '',
  `type` enum('editor','admin') NOT NULL DEFAULT 'editor',
  `signup_ip` varchar(255) NOT NULL DEFAULT '',
  `signup_time` varchar(255) NOT NULL DEFAULT '',
  `last_ip` varchar(255) NOT NULL DEFAULT '',
  `last_time` varchar(255) NOT NULL DEFAULT '',
  `activation_id` varchar(100) NOT NULL DEFAULT '',
  `recovery_id` varchar(100) NOT NULL DEFAULT '',
  `activated` enum('no','yes') NOT NULL DEFAULT 'no',
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;") || !mysql_query("INSERT IGNORE INTO `" . $_POST['db_prefix'] . "users` (`firstname`, `lastname`, `email`, `password`, `type`, `activated`) VALUES ('" . $_POST['firstname'] . "', '" . $_POST['lastname'] . "', '" . $_POST['email'] . "', '" . sha1(md5($_POST['password']) . md5($_POST['password'])) . "', 'admin', 'yes')")) {
                    $error = 'Kon tabellen niet aanmaken.' . mysql_error();
                } else {
                    $expl = explode('/', $_SERVER['PHP_SELF']);
                    
                    if(!file_exists('include/config.json')) {
                    	
                    }
                
                    file_put_contents('include/config.json', json_encode(array(
                        'sitename' => $_POST['sitename'],
                        'db_host' => $_POST['db_host'],
                        'db_database' => $_POST['db_database'],
                        'db_username' => $_POST['db_username'],
                        'db_password' => $_POST['db_password'],
                        'db_prefix' => $_POST['db_prefix'],
                        'domain' => 'http://' . str_replace($expl[2], '', $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'])
                    )));
                    
                    chmod('include/config.json', 777);
                    
                    header('Location: ./');
                    exit();
                }
            }
        }
    }
}

?><!doctype html>
<html>
    <head>
        <title>Installatie CMS</title>
        
        <style>
            
        #noticer {
            color: #ff0000;
        }
        
        </style>
    </head>
    
    <body>
        <h1>Installatie CMS</h1>
        <hr /><?php echo ($error != false ? '<span id="noticer">' . $error . '</span>' : ''); ?>
        <form action="" method="post">
            <label>
                Sitenaam:
                <br />
                <input type="text" name="sitename" value="<?php echo $_POST['sitename']; ?>" />
            </label>
            <br />
            <h2>MySQL database gegevens</h2>
            <label>
                Host:
                <br />
                <input type="text" name="db_host" value="<?php echo (isset($_POST['db_host']) ? $_POST['db_host'] : 'localhost'); ?>" />
            </label>
            <br />
            <br />
            <label>
                Database:
                <br />
                <input type="text" name="db_database" value="<?php echo $_POST['db_database']; ?>" />
            </label>
            <br />
            <br />
            <label>
                Gebruikersnaam:
                <br />
                <input type="text" name="db_username" value="<?php echo $_POST['db_username']; ?>" />
            </label>
            <br />
            <br />
            <label>
                Wachtwoord:
                <br />
                <input type="password" name="db_password" value="<?php echo $_POST['db_password']; ?>" />
            </label>
            <br />
            <br />
            <label>
                Tabellen prefix:
                <br />
                <input type="text" name="db_prefix" value="<?php echo (isset($_POST['db_prefix']) ? $_POST['db_prefix'] : 'cms_'); ?>" />
            </label>
            
            <h2>Admin gegevens</h2>
            <label>
                Voornaam:
                <br />
                <input type="text" name="firstname" value="<?php echo $_POST['firstname']; ?>" />
            </label>
            <br />
            <br />
            <label>
                Achternaam:
                <br />
                <input type="text" name="lastname" value="<?php echo $_POST['lastname']; ?>" />
            </label>
            <br />
            <br />
            <label>
                Email:
                <br />
                <input type="text" name="email" value="<?php echo $_POST['email']; ?>" />
            </label>
            <br />
            <br />
            <label>
                Wachtwoord:
                <br />
                <input type="password" name="password" />
            </label>
            <br />
            <br />
            <input type="submit" name="submit" value="Installeren" />
        </form>
    </body>
</html>