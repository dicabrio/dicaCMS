<?php if (isset($breadcrumb)) : ?>
	<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>
<ul id="tabmenu">
	<li class="active"><a href="#" class="pageinfo">PageFolder information</a></li>
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
		<div class="modulelabel">Foldername:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('folder_id'); ?>
			<?php echo $form->getFormElement('name'); ?>
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
</fieldset>
<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel">Actions:</div>
		<div class="modulecontent">
			<?php echo $form->getSubmitButton('save')->addAttribute('class', 'button'); ?>
			<a href="<?php echo Conf::get('general.url.www').'/page/folder/'.$folderid; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>

<?php echo $form->end(); ?>
			
