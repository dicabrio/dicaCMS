<?php if (isset($breadcrumb)) : ?>
	<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>
<ul id="tabmenu">
	<li class="active"><a href="#" class="pageinfo">Page information</a></li>
	<li><a href="#" class="modulesinfo">Content</a></li>
</ul>
<?php echo $form->begin(); ?>

<fieldset class="tab" id="pageinfo">
	<?php if (count($aErrors) > 0) : ?>
	<ul class="error">
		<?php foreach ($aErrors as $sError) : ?>
		<li><?php echo Lang::get('page.'.$sError); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel">Pagename:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('page_id'); ?>
			<?php echo $form->getFormElement('pagename'); ?> (voorbeeld.html zonder .html)
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Template:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('template_id'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Publishtime:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('publishtime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Expiretime:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('expiretime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Title:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('title'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Keywords:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('keywords'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Description:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('description'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Redirect:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('redirect'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel">Active:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('active'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</fieldset>
<?php if ($pageid != 0) :?>
<fieldset class="tab" id="modulesinfo">
	<?php if (count($aModules) == 0) : ?>
	<div class="pagemodule">
		<div class="modulelabel">No modules for this page</div>
		<div class="modulecontent"></div>
	</div>
	<?php else: ?>
	<?php foreach ($aModules as $oModule) :?>
		<div class="pagemodule <?php echo $oModule->sIdentifier; ?>">
			<?php echo $oModule->getContents(); ?>
			<div class="clear">&nbsp;</div>
		</div>
	<?php endforeach; ?>
	<?php endif;?>
</fieldset>
<?php endif; ?>

<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel">Actions:</div>
		<div class="modulecontent">
			<?php echo $form->getSubmitButton('save'); ?>
			<a href="<?php echo Conf::get('general.url.www').'/page/folder/'.$folderid; ?>">Cancel</a>
		</div>
	</div>
</fieldset>

<?php echo $form->end(); ?>
			
