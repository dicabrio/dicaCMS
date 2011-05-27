<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo $label; ?></h2>
	</div>
	<div class="modulecontent">

		<ul>
		<?php foreach ($pages as $page) : ?>
			<li><?php echo $form->getFormElement($identifier.'_relatedpages_'.$page->getID()); ?> <?php echo $page->getName(); ?></li>
		<?php endforeach; ?>
		</ul>


	</div>
	<div class="clear">&nbsp;</div>
</div>