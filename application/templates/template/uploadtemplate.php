<?php

	$this->addScript(Conf::get('general.url.js').'/edit_area/edit_area_full.js');
	$this->addScript(Conf::get('general.url.js').'/codeeditor.js');

?>
<?php if (isset($breadcrumb)) : ?>
	<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>

<ul id="tabmenu">
	<li class="active"><a href="#" class="pageinfo">TemplateFile information</a></li>
</ul>

<?php echo $form->begin(); ?>

<fieldset class="tab" id="pageinfo">
	<?php if (count($aErrors) > 0) : ?>
	<ul class="error">
			<?php foreach ($aErrors as $sError) : ?>
		<li><?php echo Lang::get('template.'.$sError); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel">Title:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('template_id'); ?>
			<?php echo $form->getFormElement('title'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>

	<div class="pagemodule">
		<div class="modulelabel">Corresponding Module:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('module_id'); ?>
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
		<div class="modulelabel">Template source:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('source'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>

</fieldset>
<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel">Actions:</div>
		<div class="modulecontent">
			<?php echo $form->getSubmitButton('save')->addAttribute('class', 'button'); ?>
			<a href="<?php echo Conf::get('general.url.www').'/template/folder/'.$folder_id; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>
<?php echo $form->end(); ?>

