<div class="pagemodule">
	<div class="modulelabel">
		<h2>Twitter</h2>
		<p>id: <?php echo $identifier; ?></p>
	</div>
	<div class="modulecontent">
		<table>
			<tr>
				<td><?php echo Lang::get('twitter.label.account'); ?>:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier.'_account'); ?><br /></td>
			</tr>
			<tr>
				<td><?php echo Lang::get('twitter.label.amount'); ?>:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier.'_amount'); ?></td>
			</tr>
			<tr>
				<td><?php echo Lang::get('twitter.label.template'); ?>:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier); ?><br /></td>
			</tr>
		</table>
	</div>
	<div class="clear">&nbsp;</div>
</div>