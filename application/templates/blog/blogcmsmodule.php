<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo ucfirst($identifier); ?></h2>
		<p>Type: <?php echo Lang::get('blog.title'); ?><p>
	</div>
	<div class="modulecontent">
		
		<table class="formtable">
			<tr>
				<td style="width: 120px"><?php echo Lang::get('blog.blogtemplate'); ?>:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier); ?></td>
				<td></td>
			</tr>
			<tr>
				<td style="width: 120px"><?php echo Lang::get('blog.explanation'); ?>:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier.'_amount')->addAttribute('class', 'small_input'); ?></td>
			</tr>
		</table>
	</div>
	<div class="clear">&nbsp;</div>
</div>