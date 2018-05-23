<?php

if($user->type == 'admin') {
	
?>
<h3>Gebruiker uitnodigen</h3>
<form method="post" action="">
	<label>
		Email adres:
		<br />
		<input type="email" name="email" />
	</label>
	<br />
	<label><input type="radio" name="type" value="editor" checked /> Editor</label>
	&nbsp;
	<label><input type="radio" name="type" value="admin" /> Admin</label>
	<br />
	<br />
	<input type="submit" name="submit_add" value="Uitnodiging versturen" />
</form>
<?php

}

?>