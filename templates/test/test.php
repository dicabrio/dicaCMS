<table>
<?php if ($bShowHeader) : ?>
	<thead>
		<tr><?php for ($a=0; $a < $oDataSet->getColumnCount(); $a++) : ?><td><?php echo $oDataSet->getColumnName($a); ?></td><?php endfor; ?></tr>
	</thead>
<?php endif; ?>
	<tbody>
<?php for ($i=0; $i < $oDataSet->getRowCount(); $i++) : ?>
		<tr><?php for ($j=0; $j < $oDataSet->getColumnCount(); $j++) : ?><td><?php echo $oDataSet->getValueAt($i, $j); ?></td><?php endfor; ?></tr>
<?php endfor; ?>
	</tbody>
<?php if ($bShowFooter) : ?>
	<tfoot>
		<tr><td colspan="<?php echo $oDataSet->getColumnCount(); ?>">&nbsp;</td></tr>
	</tfoot>
<?php endif; ?>
</table>
