<div class="pagemodule <?php echo $sIdentifier; ?>">
	<div class="modulelabel">
		<h2><?php echo ucfirst($identifier); ?></h2>
		<p>Type: <?php echo Lang::get('staticblock.title'); ?><p>
	</div>
	<div class="modulecontent">
		<?php echo $form->getFormElementByName($identifier); ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>