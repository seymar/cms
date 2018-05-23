
		
	<?php if($user->type == 'admin' && isset($_GET['id'])) { ?>
	<?php } else if($user->type == 'admin') { ?>	<table cellspacing="0">
		<thead>
			<tr>
				<th>E-mail</th>
				<th>Naam</th>
				<th>Laatst actief</th>
				<th>Type</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		<?php
		
		foreach($users as $key => $value) {
			?>
			<tr>
				<td><?php echo $value['email']; ?></td>
				<td><?php echo $value['firstname'] . ' ' . $value['lastname']; ?></td>
				<td><?php echo ago($value['last_time']); ?></td>
				<td><?php echo $value['type']; ?></td>
				<td><img src="../img/<?php echo ($value['enabled'] == 'yes' ? ($value['activated'] == 'yes' ? 'accept' : 'hourglass') : 'delete'); ?>.png" title="<?php echo ($value['enabled'] == 'yes' ? ($value['activated'] == 'yes' ? 'Actief' : 'Nog geen reactie op uitnodiging') : 'Gedeactiveerd'); ?>" /></td>
				<td>
					<form action="" method="post" onsubmit="return window.confirm('Wil je deze gebruiker echt verwijderen?');">
						<input type="hidden" name="user_id" value="<?php echo $key; ?>" />
						<input type="submit" name="user_delete" value="Verwijderen" />
					</form>
				</td>
			</tr>
			<?
		}
		
		?>
		</tbody>
	</table>
	<?php } ?>