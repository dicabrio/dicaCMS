			<h2>New Page</h2>
			
			<ul id="tabmenu">
				<li class="active"><a href="#" class="pageinfo">Page information</a></li>
				<li><a href="#" class="modulesinfo">Content</a></li>
			</ul>
					
			<form action="<?php echo $sPageEditFormAction; ?>" name="newpage" method="post">
				
				<fieldset>
					<legend>Actions</legend>
					<input type="submit" value="save" name="action" />
					<input type="submit" value="cancel" name="action" />
				</fieldset>
				
				<fieldset class="tab" id="pageinfo">
					<legend>Page information</legend>
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
									<input type="checkbox" name="active" id="active" value="1"<?php if ($iActive) : ?> checked="checked" <?php endif; ?>/>
								</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="page_id" value="<?php echo $iPageID; ?>" />
				</fieldset>
				<?php if ($iPageID != 0) :?>
				<fieldset class="tab" id="modulesinfo">
					<legend>Content</legend>
					<?php if (count($aModules) == 0) : ?>
						No modules for this page
					<?php else: ?>
					
					<?php foreach ($aModules as $oModule) :?>
						<div class="pagemodule <?php echo $oModule->sIdentifier; ?>"><?php echo $oModule->getContents(); ?></div>
					<?php endforeach; ?>
					
					
					<?php endif;?>
				</fieldset>
				<?php endif; ?>
				
				<fieldset>
					<legend>Actions</legend>
					<input type="submit" value="save" name="action" />
					<input type="submit" value="cancel" name="action" />
				</fieldset>
			</form>
			
