			<h2>New Page</h2>
			<fieldset>
				<legend>New page</legend>
				<form action="<?php echo WWW_URL; ?>/page/editpage/" name="newpage" method="post">
					<?php if (count($aErrors) > 0) : ?>
					<ul class="error">
					<?php foreach ($aErrors as $sError) : ?>
						<li><?php echo Lang::get($sError); ?></li>
					<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<table>
						<tbody>
							<tr>
								<td>
									<label for="pagename">Pagename: </label>
								</td>
								<td>
									<input type="text" name="pagename" id="pagename" value="<?php echo $sPagename; ?>" />.php
								</td>
							</tr>
							<tr>
								<td>
									<label for="template_id">Template: </label>
								</td>
								<td>
									<select name="template_id">
										<option value="0">Select template..</option>
										<?php foreach ($aTemplates as $oTemplateFile) : ?>
										<?php if ($oTemplateFile->getID() == $iTemplateID) :?>
										<option value="<?php echo $oTemplateFile->getID(); ?>" selected="selected"><?php echo $oTemplateFile->getTitle(); ?></option>
										<?php else: ?>
										<option value="<?php echo $oTemplateFile->getID(); ?>"><?php echo $oTemplateFile->getTitle(); ?></option>
										<?php endif; ?>
										<?php endforeach; ?>
									</select>
									Template cannot be changed
								</td>
							</tr>
							<tr>
								<td>
									<label for="publishtime">Publishtime: </label>
								</td>
								<td>
									<input type="text" name="publishtime" id="publishtime" value="<?php echo $sPublishtime; ?>" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="expiretime">Expiretime: </label>
								</td>
								<td>
									<input type="text" name="expiretime" id="expiretime" value="<?php echo $sExpiretime; ?>" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="redirect">Redirect: </label>
								</td>
								<td>
									<input type="text" name="redirect" id="redirect" value="<?php echo $sRedirect; ?>" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="active">Active: </label>
								</td>
								<td>
									<input type="checkbox" name="active" id="active" value="<?php echo $iActive; ?>" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" value="save" name="action" />
									<input type="submit" value="cancel" name="action" />
								</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="page_id" value="<?php echo $iPageID; ?>" />
				</form>
			</fieldset>
			<?php if ($iPageID != 0) :?>
			<fieldset>
				<legend>Modules</legend>
				<?php if (count($aModules) == 0) : ?>
					No modules for this page
				<?php else: ?>
				<ul>
				<?php foreach ($aModules as $aModule) :?>
					<li><?php echo $aModule['id']; ?> (<?php echo $aModule['module']; ?>) <a href="#">Edit</a></li>
				<?php endforeach; ?>
				</ul>
				<?php endif;?>
			</fieldset>
			<?php endif; ?>