<div class="modulelabel">
	<h2><?php echo ucfirst($identifier); ?></h2>
	<p>Type: Login<p>
</div>
<div class="modulecontent">
	<?php echo Lang::get('module.menuname.template'); ?>:&nbsp;
	<?php echo $form->getFormElementByName($identifier); ?>
</div>