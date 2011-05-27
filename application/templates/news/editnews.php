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
		<li><?php echo Lang::get('news.'.$sError); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('news.label.type'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('type'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('news.label.title'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('title'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('news.label.publishtime'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('publishtime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('news.label.expiretime'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('expiretime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('news.label.summary'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('summary')->addAttribute('rows', 5); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('news.label.body'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('body')->addAttribute('rows', 10); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</fieldset>
<fieldset class="actions">
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('general.actions'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('action')->addAttribute('class', 'button'); ?>
			<a href="<?php echo Conf::get('general.cmsurl.www').'/news'; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>
<?php echo $form->end(); ?>