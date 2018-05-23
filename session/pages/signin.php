					<form method="post" action="">
						<label>
							Email:
							<br />
							<input type="email" name="email" value="<?php echo @$_SESSION['email']; ?>" spellcheck="false" />
						</label>
						<label>
							Wachtwoord:
							<br />
							<input type="password" name="password" />
						</label>
						<br />
						<a href="../lost/">Wachtwoord vergeten?</a>
						<input type="submit" name="submit_signin" value="Log in" />
					</form>