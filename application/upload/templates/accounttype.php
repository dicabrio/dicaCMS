<form method="post" accept="<?php echo $sLoginFormAction; ?>" id="login">
	<fieldset>
		<legend>Login</legend>
		<?php if (is_array($aLoginErrors) && count($aLoginErrors) > 0) : ?>
		<ul class="error">
			<?php foreach ($aLoginErrors as $sError) : ?>
			<li><?php echo $sError; ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<table>
			<tr>
				<td><label>Gebruikersnaam: </label></td>
				<td><input type="text" name="username" value="<?php echo $oLoginForm->getModel('username'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Password: </label></td>
				<td><input type="password" name="password" value="<?php echo $oLoginForm->getModel('password'); ?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><span class="button"><input type="submit" name="submit" value="Login" /></span></td>
			</tr>
		</table>
		<p>
			<a href="<?php echo $sForgotPassPage; ?>">Wachtwoord vergeten</a>?
		</p>
		<input type="hidden" name="action" value="login" />
	</fieldset>
</form>
<form action="<?php echo $sRegisterFormAction; ?>" id="register" method="post">
	<fieldset>
		<legend>Registreer</legend>
		<?php if (is_array($aRegisterErrors) && count($aRegisterErrors) > 0) : ?>
		<ul class="error">
			<?php foreach ($aRegisterErrors as $sError) : ?>
			<li><?php echo $sError; ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<table>
			<tr>
				<td><label>Naam*</label></td>
				<td><input type="text" name="name" value="<?php echo $oRegisterForm->getModel('name'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Straat + Nr*</label></td>
				<td><input type="text" name="address" value="<?php echo $oRegisterForm->getModel('address'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Postcode*</label></td>
				<td><input type="text" name="zipcode" value="<?php echo $oRegisterForm->getModel('zipcode'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Plaats*</label></td>
				<td><input type="text" name="city" value="<?php echo $oRegisterForm->getModel('city'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Land*</label></td>
				<td>
					<select name="country">
						<option value="0">Kies&hellip;</option>
						<option value="NL"<?php if ($oRegisterForm->getModel('country') == 'NL') { echo ' selected="selected"'; } ?>>Nederland</option>
						<option value="BE"<?php if ($oRegisterForm->getModel('country') == 'BE') { echo ' selected="selected"'; } ?>>Belgi&euml;</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label>Telefoon</label></td>
				<td><input type="text" name="phone" value="<?php echo $oRegisterForm->getModel('phone'); ?>" /></td>
			</tr>
			<tr>
				<td><label>E-mail/ Gebruikersnaam*</label></td>
				<td><input type="text" name="email" value="<?php echo $oRegisterForm->getModel('email'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Wachtwoord*</label></td>
				<td><input type="password" name="pass" value="<?php echo $oRegisterForm->getModel('pass'); ?>" /></td>
			</tr>
			<tr>
				<td><label>Controle wachtwoord*</label></td>
				<td><input type="password" name="verifypass" value="<?php echo $oRegisterForm->getModel('verifypass'); ?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><span class="button"><input type="submit" name="submit" value="Registreer" /></span></td>
			</tr>
		</table>
		<p>
			* verplichte velden
		</p>
		<input type="hidden" name="action" value="register" />
	</fieldset>
</form>
<div class="clear">&nbsp;</div>
