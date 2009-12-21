<form action="<?php echo $sRegisterFormAction; ?>" id="register" method="post">
	<fieldset>
		<legend>Account gegevens</legend>
		<?php if (is_array($aRegisterErrors) && count($aRegisterErrors) > 0) : ?>
		<ul class="error">
			<?php foreach ($aRegisterErrors as $sError) : ?>
			<li><?php echo Lang::get('account.'.$sError); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<table>
			<tr>
				<td><label>Naam*</label></td>
				<td><input type="text" name="name" value="<?php echo $oRegisterForm->getModel('name', $sName); ?>" /></td>
			</tr>
			<tr>
				<td><label>Straat + Nr*</label></td>
				<td><input type="text" name="address" value="<?php echo $oRegisterForm->getModel('address', $sAddress); ?>" /></td>
			</tr>
			<tr>
				<td><label>Postcode*</label></td>
				<td><input type="text" name="zipcode" value="<?php echo $oRegisterForm->getModel('zipcode', $sZipcode); ?>" /></td>
			</tr>
			<tr>
				<td><label>Plaats*</label></td>
				<td><input type="text" name="city" value="<?php echo $oRegisterForm->getModel('city', $sCity); ?>" /></td>
			</tr>
			<tr>
				<td><label>Land*</label></td>
				<td>
					<select name="country">
						<option value="0">Kies&hellip;</option>
						<option value="NL"<?php if ($oRegisterForm->getModel('country', $sCountry) == 'NL') { echo ' selected="selected"'; } ?>>Nederland</option>
						<option value="BE"<?php if ($oRegisterForm->getModel('country', $sCountry) == 'BE') { echo ' selected="selected"'; } ?>>Belgi&euml;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label>Telefoon</label></td>
				<td><input type="text" name="phone" value="<?php echo $oRegisterForm->getModel('phone', $sPhone); ?>" /></td>
			</tr>
			<tr>
				<td><label>E-mail*</label></td>
				<td><input type="text" name="email" value="<?php echo $oRegisterForm->getModel('email', $sEmail); ?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><span class="button"><input type="submit" name="submit" value="Afrekenen" /></span></td>
			</tr>
		</table>
		<p>
			* verplichte velden
		</p>
		<input type="hidden" name="action" value="addcustomer" />
	</fieldset>
</form>
<div class="clear">&nbsp;</div>