<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo ucfirst($identifier); ?></h2>
		<p>Type: Login<p>
	</div>
	<div class="modulecontent">
		<table>
			<tr>
				<td><?php echo Lang::get('blog.menuname'); ?>:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier); ?></td>
			</tr>
			<tr>
				<td>Aantal blog artikelen:&nbsp;</td>
				<td><?php echo $form->getFormElementByName($identifier.'_amount')->addAttribute('class', 'small_input'); ?></td>
			</tr>
		</table>
	</div>
	<div class="clear">&nbsp;</div>
</div>