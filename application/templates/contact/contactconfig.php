<div class="pagemodule">
	<div class="modulelabel">
		<h2>Contact</h2>
		<p>id: <?php echo $identifier; ?></p>
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