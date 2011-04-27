<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo $label; ?></h2>
	</div>
	<div class="modulecontent">
		<?php if ($filename) : ?>
		<div style="float: left; border: 1px solid #eee; margin: 0 10px 0 0; text-align: center; padding: 5px;">
			<img style="border: 1px solid #ccc;" src="<?php echo Conf::get('general.url.www').Conf::get('upload.url.general').'/'.$filename; ?>" alt="<?php echo $alttext; ?>" />
		</div>
		<?php else: ?>
		<div style="float: left; margin: 0 10px 0 0; position: relative;">
			<img style="border: 1px solid #ccc;" src="<?php echo Conf::get('general.url.images').'/'.$defaultimage; ?>" alt="" width="150" />
			<div style="font-size: 18px;position: absolute; top: 50%; margin: -10px 0 0 0; height: 20px; width: 100%; text-align: center; color: #666;"><?php echo Lang::get('imageupload.label.placeholder'); ?></div>
		</div>
		<?php endif; ?>
		<div style="float: left;width: 400px;">
			<p>
				Het bestand mag niet groter zijn dan <?php echo Conf::get('imageupload.allowedsize.width'); ?>px breed en <?php echo Conf::get('imageupload.allowedsize.height'); ?>px hoog.
				<br />
				<br />
				<br />
			</p>
			<?php echo $form->getFormElement($identifier); ?><br /><br />
			<label style="width: 100px; float: left;" for="<?php echo $identifier."title"; ?>"><?php echo Lang::get('imageupload.alttext'); ?></label>
			<?php echo $form->getFormElement($identifier."title")->addAttribute('style', 'width: 230px; margin: 0 0 5px 0;'); ?>
			<?php if (isset($extended) && $extended == true) : ?>
			<label style="width: 100px; float: left;" for="<?php echo $identifier."description"; ?>"><?php echo Lang::get('imageupload.description'); ?></label>
			<?php echo $form->getFormElement($identifier."description")->addAttribute('style', 'width: 230px;'); ?>
			<?php endif; ?>
		</div>

		<div class="clear">&nbsp;</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>