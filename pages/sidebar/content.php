<?php

if(isset($_GET['id'])) {
	if($user->type == 'admin') {
?>
		<h3>Type</h3>
		<form action="" method="post" name="content_type_form">
			<label><input type="radio" name="content_type" value="single"<?php echo ($contents->fetch['type'] == 'single' ? ' checked="checked"' : ''); ?> /> Enkelvoudig</label>
			<br />
			<label><input type="radio" name="content_type" value="multiple"<?php echo ($contents->fetch['type'] == 'multiple' ? ' checked="checked"' : ''); ?> /> Meervoudig</label>
			<br />
			<br /><input type="submit" name="content_type_submit" value="Opslaan" />
		</form>
		<hr />
		<?php
		
		if($contents->fetch['type'] == 'multiple') {
		
		?>
			<h3>HTML rond content</h3>
		<form action="" method="post">
			<label>
				Voor:
				<textarea name="content_settings_before"><?php echo htmlentities($contents->fetch['before']); ?></textarea>
			</label>
			<label>
				Na:
				<textarea name="content_settings_after"><?php echo htmlentities($contents->fetch['after']); ?></textarea>
			</label>
			<input type="submit" name="content_settings_submit" value="Opslaan" />
		</form>
		<hr /><?php
		
		}
	}
?>
<h3>Foto invoegen</h3>

<div id="media">
	<?php
	
	if(sizeof($media->fetch) == 0) {
		
	?>
	<a href="<?php echo PATH_CLIENT; ?>media/">Nog geen foto's ge&uuml;pload!</a>
	<?php
	
	}
	
	foreach($media->fetch as $key => $value) {
		echo '<img src="../../uploads/' . $value['id'] . '.' . $value['ext'] . '" onclick="insert_ubb(ctf, \'\', \'[img h=100 w=100]' . domain . 'uploads/' . $value['id'] . '.' . $value['ext'] . '[/img]\');" class="thumb" alt="" />';
	}
	
	?>
</div>

<?php

} else {

?>
<h3>Content</h3>
Kies een stuk content om te bewerken.
<?php

}

?>