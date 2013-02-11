<?php
/* @var $this DicaView */
/* @var $form Form */
?>
<?php echo $form->begin(); ?>
<div class="area_edit">
	<table>
		<thead>
			<tr>
				<th><?php echo Lang::get('area.area'); ?></th>
				<th><?php echo Lang::get('area.user_groups'); ?></th>
				<th><?php echo Lang::get('area.redirect'); ?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($areas as $area) : ?>

			<tr>
				<td valign="top"><?php echo $area->getName(); ?></td>
				<td valign="top"><?php echo $form->getFormElement('area_'.$area->getName().'_user_group'); ?></td>
				<td valign="top"><?php echo $form->getFormElement('area_'.$area->getName().'_redirect'); ?></td>
			</tr>

			<?php endforeach; ?>

		</tbody>
	</table>

	<div class="actions">
		<?php echo $form->getFormElement('action')->addAttribute('class', 'button'); ?>
	</div>
</div>
<?php echo $form->end(); ?>