<div class="modulelabel">
	<h2><?php echo Lang::get('pricelist.title'); ?></h2>
	<p>id: <?php echo $identifier; ?> </p>
</div>
<div class="modulecontent">
	<?php echo $form->getFormElement($identifier)->addAttribute('maxlenght', $sMaxLength); ?>
</div>