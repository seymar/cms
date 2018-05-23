					<form method="post" action="">
						<label>
							Email:
							<br />
							<input type="email" name="email" spellcheck="false" value="<?php echo @$_SESSION['email']; ?>" />
						</label>
						<br />
						<input type="submit" name="submit_lost" value="Vergeten" />
					</form>