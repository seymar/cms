<?php

if(isset($_GET['id'])) {

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
<h3>Blog</h3>
Beheer hier je artikelen.
<?php

}

?>