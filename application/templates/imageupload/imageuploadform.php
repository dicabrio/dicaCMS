<div class="modulelabel">
	<h2><?php echo Lang::get('imageupload.title'); ?></h2>
	<p>id: <?php echo $sIdentifier; ?><p>
</div>
<div class="modulecontent">
	<?php if ($filename) : ?>
	<img src="<?php echo Conf::get('general.url.www').Conf::get('upload.url.general').'/'.$filename; ?>" alt="<?php echo $alttext; ?>" width="100" /><br />
	<?php endif; ?>
	<?php echo $form->getFormElement($sIdentifier); ?><br /><br />
	<label for="<?php echo $sIdentifier."description"; ?>"><?php echo Lang::get('imageupload.description'); ?></label>
	<?php echo $form->getFormElement($sIdentifier."description"); ?>
	<div class="clear">&nbsp;</div>
</div>
