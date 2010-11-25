	<ul id="actions">
		<li><a href="<?php echo Conf::get('general.url.www'); ?>/tag/edit/">Tag toevoegen</a></li>
	</ul>

	<?php if (count($errors) > 0) : ?>
	<ul class="error">
			<?php foreach ($errors as $sError) : ?>
		<li><?php echo Lang::get('server.'.$sError); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<table class="dataset">
		<thead>
			<tr>
				<td>#</td>
				<td>Naam</td>
				<td>Acties</td>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($tags as $tag): ?>
			<tr>
				<td><?php echo $tag->getID(); ?></td>
				<td><?php echo $tag->getName(); ?></td>
				<td>
					<a class="button" href="<?php echo Conf::get('general.url.www'); ?>/tag/edit/<?php echo $tag->getID(); ?>">Wijzig</a>
					<a class="button deletepage" confirm="weet je het zeker dat je deze tag wilt verwijderen?" href="<?php echo Conf::get('general.url.www'); ?>/tag/delete/<?php echo $tag->getID(); ?>">Verwijder</a>
				</td>
			</tr>
			<?php endforeach ?>

		</tbody>
	</table>