<div class="modulelabel">
	<h2><?php echo Lang::get('static.editpagetitle'); ?></h2>
	<p>id: <?php echo $identifier; ?><p>
</div>
<div class="modulecontent">
	<?php echo $form->getFormElementByName($identifier); ?>
</div>