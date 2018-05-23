					<form method="post" action="">
						<label>
							Voornaam:
							<br />
							<input type="text" name="firstname" value="<?php echo @$_POST['firstname']; ?>" />
						</label>
						<label>
							Achternaam:
							<br />
							<input type="text" name="lastname" value="<?php echo @$_POST['lastname']; ?>" />
						</label>
						<label>
							Wachtwoord:
							<br />
							<input type="password" name="password" />
						</label>
						<label>
							Bevestig wachtwoord:
							<br />
							<input type="password" name="password_confirm" />
						</label>
						<input type="submit" name="submit_signup" value="Verzenden" />
					</form>