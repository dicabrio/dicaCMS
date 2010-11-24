<div class="pagemodule <?php echo $sIdentifier; ?>">
	<div class="modulelabel">
		<h2><?php echo Lang::get('textline.title'); ?></h2>
		<p>id: <?php echo $sIdentifier; ?> </p>
	</div>
	<div class="modulecontent">
		<?php echo $form->getFormElement($sIdentifier)->addAttribute('maxlenght', $sMaxLength); ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>