<?php

if(!isset($_GET['id'])) {

?>
<form action="" method="post">
	<input type="submit" name="add" value="Nieuw artikel" />
</form>
<br />
<ul>
	<?php

	foreach($articles->all(false) as $article) {

	?>
	<li>
		<img src="<?php echo PATH_CLIENT; ?>img/page_white_text.png" height="16" width="16" alt="page" />
		<a href="<?php echo $article->id; ?>/"><?php echo $article->title; ?></a>
		<span class="right">
			<span class="date"><?php echo date('d-m-Y', $article->published); ?></span>
			<input type="checkbox" class="switch" id="switch<?php echo $article->id; ?>" <?php if($article->visibility == 1) { echo ' checked="checked"';} ?> />
			<label for="switch<?php echo $article->id; ?>"><span class="handle"></span></label>
		</span>
	</li>
	<?php
		
	}

	?>
</ul>
<?php

} else {

?>
<h3>Artikel wijzigen</h3>
<form action="../" method="post">
	<input type="text" name="title" placeholder="Titel" value="<?php echo $article->title; ?>" />
	<br />
	<textarea name="body" onfocus="ctf = this" placeholder="Inhoud"><?php echo $article->body; ?></textarea>
	<br />
	<input type="hidden" name="id" value="<?php echo $article->id; ?>" />
	<input type="submit" name="update" value="Opslaan" />
	<input type="submit" name="delete" value="Verwijderen" />
	<span class="tooltip">Voor de opmaak van je content kan je HTML en UBB codes gebruiken!</span>
</form>
<?php
	
}

?>