<div class="modulelabel">
	<?php echo $identifier; ?>:
</div>
<div class="modulecontent">
	<select name="<?php echo $identifier; ?>">
		<option value="0">Choose..</option>
		<?php foreach ($blocks as $block) : ?>
		<option value="<?php echo $block->getID(); ?>" <?php if ($block_id == $block->getID()) : ?> selected="selected"<?php endif; ?>><?php echo $block->getTitle(); ?></option>
		<?php endforeach; ?>
	</select>
</div>