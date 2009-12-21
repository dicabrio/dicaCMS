<div id="credentials">


	<fieldset>
		<legend>Gegevens</legend>
		<table>
			<tr>
				<td><label>Naam:</label></td>
				<td><?php echo $oKlant->naam; ?></td>
			</tr>
			<tr>
				<td><label>Straat + Nr.:</label></td>
				<td><?php echo $oKlant->straat; ?></td>
			</tr>
			<tr>
				<td><label>Postcode:</label></td>
				<td><?php echo $oKlant->postcode; ?></td>
			</tr>
			<tr>
				<td><label>Plaats:</label></td>
				<td><?php echo $oKlant->plaats; ?></td>
			</tr>
			<tr>
				<td><label>Land:</label></td>
				<td><?php echo $oKlant->land; ?></td>
			</tr>
			<tr>
				<td><label>Telefoon:</label></td>
				<td><?php echo $oKlant->telefoon; ?></td>
			</tr>
			<tr>
				<td><label>E-mail:</label></td>
				<td><?php echo $oKlant->email; ?></td>
			</tr>
		</table>
	</fieldset>
	<div class="clear">&nbsp;</div>
	<span class="button">
		<a href="mandje.php">Naar Mandje</a>
	</span>
	<span class="button">
		<a href="afrekenen.php">Afrekenen</a>
	</span>
</div>