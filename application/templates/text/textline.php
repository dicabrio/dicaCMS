<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo $label; ?></h2>
	</div>
	<div class="modulecontent">
		<?php echo $form->getFormElement($identifier)->addAttribute('maxlenght', $maxlength); ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>