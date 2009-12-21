					<form action="<?php echo $sFormAction; ?>#anchornieuwsbrief" id="nieuwsbrief" method="post">
						<fieldset>
<?php if (count($aErrors) > 0) : ?>
							<ul class="error">
								<?php foreach ($aErrors as $sError) : ?>
								<li><?php echo $sError; ?></li>
								<?php endforeach; ?>
							</ul>
<?php endif; ?>
<?php if ($bNotification) :?>
							<div class="notify">Je ontvangt van ons een e-mail om je aanmelding te bevestigen.</div>
<?php endif; ?>
							<label>Naam:</label><input type="text" name="name" value="<?php echo $sName; ?>" /><br />
							<label>E-mail:</label><input type="text" name="email" value="<?php echo $sEmail; ?>" /><br />
							<span class="button"><input type="submit" name="submit" value="Aanmelden" /></span>
							<input type="hidden" name="nieuwsbrief" value="1" />
							<input type="hidden" name="tick" value="<?php echo $iTick; ?>" />
							
						</fieldset>			
					</form>
