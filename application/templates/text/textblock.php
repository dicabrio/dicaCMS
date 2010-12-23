<div class="pagemodule <?php echo $sIdentifier; ?>">
	<div class="modulelabel">
		<h2><?php echo Lang::get('textblock.title'); ?></h2>
		<p>id: <?php echo $sIdentifier; ?><p>
	</div>
	<div class="modulecontent yui-skin-sam">
		<?php echo $form->getFormElement($sIdentifier)->addAttribute('class', 'moduletextblock '.$sIdentifier)->addAttribute('rows', 50)->addAttribute('cols', 50); ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>
