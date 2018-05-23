<?php

include_once './main.php';

?><!doctype html>
<html>
	<head>
		<title>CMS</title>
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=600">
		
		<link rel="stylesheet" href="<?php echo (isset($_GET['id']) ? '../' : ''); ?>../css/main.css" />
	</head>
	<body>
		<div id="container">
			<div id="wrapper">			
				<div id="header">
					<h1>
						<a href="../">
							C<span>M</span>S
						</a>
					</h1>
				</div>
				
				<div id="noticer" class="noticer <?php echo (defined('OUTPUT_NOTICER_STATE') ? OUTPUT_NOTICER_STATE : 'disabled'); ?>"><?php echo (defined('OUTPUT_NOTICER_TEXT') ? OUTPUT_NOTICER_TEXT : ''); ?></div>
				
				<?php
				
				if(@$disablecontent != true) {
					echo '<div id="content">' . "\n";
					
					include_once './pages/' . $_GET['page'] . '.php';
					
					echo '</div>' . "\n";
				}
				
				?>
			</div>
			
			<!--<div id="footer">
				&copy; 2010
				<span>
					<a href="http://twitter.com/stijntjhe">Support</a>
				</span>
			</div>-->
		</div>
	</body>
</html>