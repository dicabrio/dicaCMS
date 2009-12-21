			<h2>New Page</h2>
			
			<ul id="tabmenu">
				<li class="active"><a href="#" class="pageinfo">Page information</a></li>
				<li><a href="#" class="modulesinfo">Content</a></li>
			</ul>


			
			<?php echo $form->begin(); ?>
				
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
									<?php echo $form->getFormElement('page_id'); ?>
									<?php echo $form->getFormElement('pagename'); ?>.php
								</td>
							</tr>
							<tr>
								<td>
									<label for="template_id">Template: </label>
								</td>
								<td>
									<?php echo $form->getFormElement('template_id'); ?>
									Template cannot be changed
								</td>
							</tr>
							<tr>
								<td>
									<label for="publishtime">Publishtime: </label>
								</td>
								<td>
									<?php echo $form->getFormElement('publishtime'); ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="expiretime">Expiretime: </label>
								</td>
								<td>
									<?php echo $form->getFormElement('expiretime'); ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="redirect">Redirect: </label>
								</td>
								<td>
									<?php echo $form->getFormElement('redirect'); ?>
								</td>
							</tr>
							<tr>
								<td>
									<label for="active">Active: </label>
								</td>
								<td>
									<?php echo $form->getFormElement('active'); ?>
								</td>
							</tr>
						</tbody>
					</table>
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

					<?php echo $form->getSubmitButton('save'); ?>
					<a href="javascript:history.go(-1);">Cancel</a>

				</fieldset>
			<?php echo $form->end(); ?>
			
