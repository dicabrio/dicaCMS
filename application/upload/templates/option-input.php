						<?php if (isset($sError)) : ?>
						<li class="errormessage"><?php echo $sError; ?></li>
						<?php endif; ?>
						<li <?php if (isset($sError)) : ?>class="error"<?php endif; ?>>
							<label for="<?php echo $sName; ?>"><?php echo $sLabel; ?>:</label>
							<input type="text" id="<?php echo $sName; ?>" name="<?php echo $sName; ?>" class="small" value="<?php echo $sValue; ?>" />
						</li>