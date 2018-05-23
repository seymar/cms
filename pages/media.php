<ul class="gallery">
<?php

foreach($media->fetch as $key => $value) {

?>
<li>
	<img src="../uploads/<?php echo $value['id'] . '.' . $value['ext']; ?>" class="thumb" alt="<?php echo $value['name']; ?>" />
	<a href="../uploads/<?php echo $value['id'] . '.' . $value['ext']; ?>"><?php echo htmlentities($value['name']); ?></a>
	<form action="" method="post" class="delete"><input type="hidden" name="id" value="<?php echo $value['id']; ?>" /><input name="media_delete" class="delete_button"  type="submit" value="Verwijderen" /></form>
</li>
<?php

	}
	
?>
</ul>