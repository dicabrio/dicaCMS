<div class="modulelabel">
	<h2><?php echo Lang::get('general.title.textblock'); ?></h2>
	<p>id: <?php echo $sIdentifier; ?><p>
</div>
<div class="modulecontent yui-skin-sam">
	<textarea name="<?php echo $sIdentifier; ?>" id="<?php echo $sIdentifier; ?>" class="moduletextblock <?php echo $sIdentifier; ?>" rows="50" cols="50"><?php echo htmlentities($sContent, ENT_COMPAT, 'UTF-8'); ?></textarea>
</div>
