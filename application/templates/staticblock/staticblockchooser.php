<div class="modulelabel">
	<h2><?php echo Lang::get('static.editpagetitle'); ?></h2>
	<p>id: <?php echo $identifier; ?><p>
</div>
<div class="modulecontent">
	<select name="<?php echo $identifier; ?>">
		<option value="0">Choose..</option>
		<?php foreach ($blocks as $block) : ?>
		<option value="<?php echo $block->getID(); ?>" <?php if ($block_id == $block->getID()) : ?> selected="selected"<?php endif; ?>><?php echo $block->getIdentifier(); ?></option>
		<?php endforeach; ?>
	</select>
</div>