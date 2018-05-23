<?php

$layout = 'auth';

?><form action="" method="post"><?php $this->Session->flash(); ?>
	<input type="email" name="email" />
	<input type="password" name="password" />
	<input type="submit" class="button" name="submitButton" value="Login" />
</form>