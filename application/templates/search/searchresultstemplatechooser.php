<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo ucfirst($identifier); ?></h2>
		<p>Type: <?php echo Lang::get('search.title'); ?><p>
	</div>
	<div class="modulecontent">
		<?php echo $form->getFormElementByName($identifier); ?>
		Selecteer een template hoe je de resultaten wilt weergeven
	</div>
	<div class="clear">&nbsp;</div>
</div>