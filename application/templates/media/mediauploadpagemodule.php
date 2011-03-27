<?php echo $form->begin(); ?>

<fieldset class="tab" id="pageinfo">
	<?php if (count($errors) > 0) : ?>
		<ul class="error">
		<?php foreach ($errors as $error) : ?>
			<li><?php echo Lang::get('media.' . $error); ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>


			<table>
				<tr>
					<th>Titel</th>
					<td><?php echo $form->getFormElement('title'); ?></td>
				</tr>
				<tr>
					<th>Omschrijving</th>
					<td><?php echo $form->getFormElement('description'); ?></td>
				</tr>
				<tr>
					<th>Bestand</th>
					<td><?php echo $form->getFormElement('media'); ?></td>
				</tr>
				<tr>
					<th>Tags</th>						
					<td>			
						<ul>						
						<?php foreach ($tags as $tag) : ?>
							<li><?php echo $form->getFormElement('tags_' . $tag->getName()); ?> <?php echo $tag->getName(); ?></li>
						<?php endforeach; ?>
						</ul>		
					</td>			
				</tr>			
				<tr>
					<th></th>
					<td><?php echo $form->getSubmitButton('action')->addAttribute('class', 'button'); ?></td>
				</tr>
			</table>
		</fieldset>	
<?php echo $form->end(); ?>