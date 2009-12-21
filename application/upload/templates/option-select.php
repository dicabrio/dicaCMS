						<?php if (isset($sError)) : ?>
						<li class="errormessage"><?php echo $sError; ?></li>
						<?php endif; ?>
						<li <?php if (isset($sError)) : ?>class="error"<?php endif; ?>>
							<label for="<?php echo $sName; ?>"><?php echo $sLabel; ?>:</label>
							<select id="<?php echo $sName; ?>" name="<?php echo $sName; ?>">
							<?php foreach ($aOptions as $aOption) : ?>
								<?php 
								$sSelected = ''; 
								if ($aOption->value == $sValue) { 
									 $sSelected = ' selected="selected"'; 
								} 
								?>
								<option value="<?php echo $aOption->value; ?>"<?php echo $sSelected; ?> title="<?php echo $aOption->label; ?>"><?php echo $aOption->label; ?></option>
							<?php endforeach; ?>
							</select>
						</li>