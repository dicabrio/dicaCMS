<?php $this->addScript(Conf::get('general.url.js').'/server.js'); ?>
<?php $this->addStyle(Conf::get('general.url.css').'/server.css'); ?>
<ul id="tabmenu">
	<li class="active"><a href="#"><?php echo Lang::get('product.edittab'); ?></a></li>
</ul>
<?php echo $form->begin(); ?>
<fieldset class="tab">
	<?php if (count($errors) > 0) : ?>
	<ul class="error">
			<?php foreach ($errors as $sError) : ?>
		<li><?php echo Lang::get('product.'.$sError); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.type'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('type'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.title'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('title'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.price'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('price'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.image'); ?>:</div>
		<div class="modulecontent">

			<?php if ($productimage) : ?>
			<img src="<?php echo Conf::get('general.url.www').Conf::get('upload.url.general'); ?>/<?php echo $productimage; ?>" alt="image" /><br />
			<?php endif; ?>
			<?php echo $form->getFormElement('image'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.detailimage'); ?>:</div>
		<div class="modulecontent">
			<?php if ($productdetailimage) : ?>
			<img src="<?php echo Conf::get('general.url.www').Conf::get('upload.url.general'); ?>/<?php echo $productdetailimage; ?>" alt="image" /><br />
			<?php endif; ?>
			<?php echo $form->getFormElement('detailimage'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.publishtime'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('publishtime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.expiretime'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('expiretime'); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.summary'); ?>:</div>
		<div class="modulecontent">
			<?php echo $form->getFormElement('summary')->addAttribute('rows', 5); ?>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
	<div class="pagemodule">
		<div class="modulelabel"><?php echo Lang::get('product.label.body'); ?>:</div>
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
			<a href="<?php echo Conf::get('general.cmsurl.www').'/product'; ?>" class="button">Cancel</a>
		</div>
	</div>
</fieldset>
<?php echo $form->end(); ?>