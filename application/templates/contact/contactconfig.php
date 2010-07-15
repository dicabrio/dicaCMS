<div class="modulelabel">
	<?php echo $sIdentifier; ?>:
</div>
<div class="modulecontent">
	<table>
		<tr>
			<td>Ontvangst email:&nbsp;&nbsp; </td>
			<td><?php echo $form->getFormElementByName($sIdentifier); ?></td>
		</tr>
		<tr>
			<td>Bedanktpagina:&nbsp;&nbsp;</td>
			<td><?php echo $form->getFormElementByName("bedanktpagina"); ?></td>
		</tr>
	</table>
</div>