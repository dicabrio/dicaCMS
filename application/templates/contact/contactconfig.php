<div class="pagemodule <?php echo $identifier; ?>">
	<div class="modulelabel">
		<h2><?php echo $label; ?></h2>
	</div>
	<div class="modulecontent">
		<table>
			<tr>
				<td>Ontvangst email:&nbsp;&nbsp; </td>
				<td><?php echo $form->getFormElementByName($identifier); ?></td>
			</tr>
			<tr>
				<td>Bedanktpagina:&nbsp;&nbsp;</td>
				<td><?php echo $form->getFormElementByName("bedanktpagina"); ?></td>
			</tr>
		</table>
	</div>
	<div class="clear">&nbsp;</div>
</div>