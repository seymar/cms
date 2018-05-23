<?php
    
    include_once './main.php';
    
?><!doctype html>
<html>
    <head>
        <title>CMS <?php echo sitename; ?></title>
        
        <meta charset="utf-8" />
		<meta name="viewport" content="width=1100">
		
        <link rel="stylesheet" href="<?php echo PATH_CLIENT; ?>css/main.css" />
        
        <script src="<?php echo PATH_CLIENT; ?>js/jquery.js"></script>
        <script src="<?php echo PATH_CLIENT; ?>js/main.js"></script>
    </head>
    
    <body>
    	<div id="container">
        	<div id="header">
                <h1>
                    <a href="<?php echo PATH_CLIENT; ?>">
                        C<span>M</span>S
                    </a>
                </h1>
                <h2><?php echo sitename; ?></h2>
				
				<div id="nav">
					<a href="<?php echo PATH_CLIENT; ?>content/"<?php echo ($_GET['page'] == 'content' ? ' class="active"' : ''); ?>><img src="<?php echo PATH_CLIENT; ?>img/page_edit.png" alt="content" />Content</a>
					<a href="<?php echo PATH_CLIENT; ?>blog/"<?php echo ($_GET['page'] == 'blog' ? ' class="active"' : ''); ?>><img src="<?php echo PATH_CLIENT; ?>img/page_white_text.png" alt="blog" />Blog</a>
					<a href="<?php echo PATH_CLIENT; ?>media/"<?php echo ($_GET['page'] == 'media' ? ' class="active"' : ''); ?>><img src="<?php echo PATH_CLIENT; ?>img/pictures.png" alt="media" />Media</a><?php if($user->type == 'admin') { ?>
					<a href="<?php echo PATH_CLIENT; ?>users/"<?php echo ($_GET['page'] == 'users' ? ' class="active"' : ''); ?>><img src="<?php echo PATH_CLIENT; ?>img/user.png" alt="gebruikers" />Users</a><?php } ?>
					<a href="<?php echo PATH_CLIENT; ?>account/"<?php echo ($_GET['page'] == 'users' ? ' class="active"' : ''); ?>><img src="<?php echo PATH_CLIENT; ?>img/cog.png" alt="account" />Account</a>
					<a href="<?php echo PATH_CLIENT; ?>signout/"><img src="<?php echo PATH_CLIENT; ?>img/delete.png" alt="sign out">Sign out</a>
				</div>
            </div>
            
	        <div id="sidebar">
	            <?php
	            
	            include_once './pages/sidebar/' . $_GET['page'] . '.php';
	            
	            ?>
			</div>
	        
	        <div id="content">
	            <div class="noticer <?php echo (defined('OUTPUT_NOTICER_STATE') ? OUTPUT_NOTICER_STATE : 'disabled'); ?>">
	            <?php echo (defined('OUTPUT_NOTICER_TEXT') ? OUTPUT_NOTICER_TEXT : ''); ?></div><?php
	            
	            include_once './pages/' . $_GET['page'] . '.php';
	            
	            ?>
	        </div>
	        
	        <div style="clear:both;height: 15px;"></div>
    	</div>
	                    
		<div id="footer">
			&copy; <?php echo date('Y'); ?> - <a href="http://devcube.nl">Devcube Development</a>
		</div>
    </body>
</html>