<?php

if(!isset($_GET['id'])) {

?>
<ul>
	<?php
	
	$_pages = $pages->fetch();
	
	if(!$_pages) {
		echo 'No pages or content';
	}
	
	foreach($_pages as $key => $value) {

	?>
	<li>
		<img src="<?php echo PATH_CLIENT; ?>img/page.png" height="16" width="16" alt="page" />
		<?php echo (empty($value['name']) ? $value['file'] : htmlentities($value['name'])); ?>
		<?php

		if($user->type == 'admin') {

		?>
		<form action="" method="post" onsubmit="return window.confirm('Wil je deze pagina echt verwijderen?');">
			<input type="hidden" name="page_id" value="<?php echo $key; ?>" />
			<input type="submit" name="page_delete" value="Verwijderen" />
		</form>
		<?php

			}

		?>
	</li>
	<ul>
		<?php
		
		foreach($contents->fetch($key) as $key2 => $value2) {
		
		?>
		<li>
			<img src="<?php echo PATH_CLIENT; ?>img/<?php echo ($value2['type'] == 'single' ? 'text_dropcaps' : 'text_list_bullets'); ?>.png" height="16" width="16" alt="content" />
			<a href="<?php echo $value2['id']; ?>/"><?php echo htmlentities($value2['name']); ?></a>
			<?php

			if($user->type == 'admin') {

			?>
			<form action="" method="post" onsubmit="return window.confirm('Wil je deze content echt verwijderen?');">
				<input type="hidden" name="content_id" value="<?php echo $key2; ?>" />
				<input type="submit" name="content_delete" value="Verwijderen" />
			</form>
			<?php

			}

			if($value2['incode'] == 'false') {

			?>
			<img src="<?php echo PATH_CLIENT; ?>img/error.png" class="icon" height="16" width="16" alt="Niet gevonden op website" title="Niet gevonden op website" />
			<?php
				
			}

			?>
		</li>
		<?php

		}
		
		?>
	</ul>
	<?php
		
	}

	?>
</ul>
<?php

} else {
	if($contents->fetch['type'] == 'single') {

	?>
	<h3><?php echo $contents->fetch['name']; ?></h3>
	<form action="" method="post">
		<textarea name="text" onfocus="ctf = this"><?php echo $contents->fetch['text']; ?></textarea>
		<br />
		<input type="submit" name="opslaan" value="Opslaan" /> <span class="tooltip">Voor de opmaak van je content kan je HTML en UBB codes gebruiken!</span>
	</form>
	<?php
	
	} else {
	
	?>
	<form action="" method="post">
		<textarea name="multiple_content" onfocus="ctf = this"></textarea>
		<br />
		<input type="submit" name="multiple_add" value="Toevoegen" />
	</form>
	<?php

	foreach(@$multiples->fetch($_GET['id']) as $key => $value) {

	?>
	<hr />
	<form action="" method="post">
		<textarea name="multiple_text" onfocus="ctf = this"><?php echo htmlentities($value['content']); ?></textarea>
		<input type="hidden" name="multiple_id" value="<?php echo $key; ?>" />
		<br />
		<input type="submit" name="multiple_submit" value="Opslaan" /> <input type="submit" name="multiple_delete" value="Verwijderen" />
	</form>
	<?php

	}
	
	}

}

?>