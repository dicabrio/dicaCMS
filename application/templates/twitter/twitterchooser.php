<div class="modulelabel">
	<h2>Twitter</h2>
	<p>id: <?php echo $identifier; ?><p>
</div>
<div class="modulecontent">
	<?php echo Lang::get('module.menuname.template'); ?>:&nbsp;
	<select name="<?php echo $identifier; ?>">
		<option value="0">Choose..</option>
		<?php foreach ($blocks as $block) : ?>
		<option value="<?php echo $block->getID(); ?>" <?php if ($block_id == $block->getID()) : ?> selected="selected"<?php endif; ?>><?php echo $block->getTitle(); ?></option>
		<?php endforeach; ?>
	</select>
</div>