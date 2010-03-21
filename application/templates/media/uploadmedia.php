<?php if (isset($breadcrumb)) : ?>
	<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>

<ul id="tabmenu">
	<li class="active"><a href="#" class="pageinfo">Media information</a></li>
</ul>

<?php echo $form->begin(); ?>

<fieldset class="tab" id="pageinfo">
	<?php if (count($aErrors) > 0) : ?>
	<ul class="error">
			<?php foreach ($aErrors as $sError) : ?>
		<li><?php echo Lang::get('media.'.$sError); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel">Title:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('media_id'); ?>
			<?php echo $form->getFormElement('title'); ?>
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
		<div class="modulelabel">File:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('media'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>

	<?php if ($updatemode) : ?>
	<div class="pagemodule">
		<div class="modulelabel">Filename:</div>
		<div class="modulecontent">
			<?php echo $filename; ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<?php endif; ?>

</fieldset>
<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel">Actions:</div>
		<div class="modulecontent">
			<?php echo $form->getSubmitButton('save')->addAttribute('class', 'button'); ?>
			<a href="<?php echo Conf::get('general.url.www').'/media'; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>

<?php echo $form->end(); ?>