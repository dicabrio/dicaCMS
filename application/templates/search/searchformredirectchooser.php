<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo ucfirst($identifier); ?></h2>
		<p>Type: <?php echo Lang::get('search.title'); ?><p>
	</div>
	<div class="modulecontent">
		<?php echo $form->getFormElementByName($identifier); ?>
		Geef aan op welke pagina je de zoekresultaten laat weergeven
	</div>
	<div class="clear">&nbsp;</div>
</div>