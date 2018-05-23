					<form method="post" action="">
						<label>
							Email:
							<br />
							<input type="email" name="email" spellcheck="false" value="<?php echo @$_SESSION['email']; ?>" />
						</label>
						<br />
						Check je mailbox!
						<input type="submit" name="submit_resend" value="Verzend activatie email" />
					</form>