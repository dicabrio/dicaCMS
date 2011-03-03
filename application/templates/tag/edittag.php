<?php $this->addScript(Conf::get('general.url.js').'/server.js'); ?>
<?php $this->addStyle(Conf::get('general.url.css').'/server.css'); ?>
<ul id="tabmenu">
	<li class="active"><a href="#">Edit Server</a></li>
</ul>
<?php echo $form->begin(); ?>
<fieldset class="tab">
	<?php if (count($errors) > 0) : ?>
	<ul class="error">
			<?php foreach ($errors as $sError) : ?>
		<li><?php echo Lang::get('tag.'.$sError); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel">Name:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('name'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</fieldset>
<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel">Actions:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('action')->addAttribute('class', 'button'); ?>
			<a href="<?php echo Conf::get('general.cmsurl.www').'/tag'; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>
<?php echo $form->end(); ?>