<?php

$this->addScript(Conf::get('general.url.js').'/cms/pagelist.js');

$this->addStyle(Conf::get('general.url.css').'/modules/pagelist.css');

?>
<div class="pagemodule <?php echo $identifier; ?> pagelist">
	<div class="modulelabel">
		<h2><?php echo $label; ?></h2>
	</div>
	<div class="modulecontent">
		
		<?php echo $form->getFormElement($identifier); ?>
		<div class="template">
			<div class="row">
				<?php echo $form->getFormElement('pagelist_pages'); ?>
				<a href="#" class="add">+</a>
				<a href="#" class="sub hide">-</a>
			</div>
		</div>
		
		<div class="placeholder">
			
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>