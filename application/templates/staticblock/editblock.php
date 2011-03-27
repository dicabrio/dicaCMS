<?php if (isset($breadcrumb)) : ?>
	<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>
<ul id="tabmenu">
	<li class="active"><a href="#" class="pageinfo"><?php echo Lang::get('staticblock.tab.information'); ?></a></li>
</ul>

<?php echo $form->begin(); ?>
<fieldset class="tab" id="pageinfo">
	<?php if (count($aErrors) > 0) : ?>
	<ul class="error">
		<?php foreach ($aErrors as $sError) : ?>
		<li><?php echo Lang::get('static.'.$sError); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('staticblock.name'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('name'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('staticblock.identifier'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('block_id'); ?>
			<?php echo $form->getFormElement('identifier'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('staticblock.content'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('content')->addAttribute('class', 'moduletextblock'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</fieldset>
<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('general.actions'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getSubmitButton('action')->addAttribute('class', 'button'); ?>
			<a href="<?php echo Conf::get('general.cmsurl.www').'/staticblock'; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>
<?php echo $form->end(); ?>

