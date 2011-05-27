	<ul id="actions">
		<li><a href="<?php echo Conf::get('general.cmsurl.www'); ?>/product/edit/"><?php echo Lang::get('product.button.addnews'); ?></a></li>
	</ul>

	<?php if (count($errors) > 0) : ?>
	<ul class="error">
			<?php foreach ($errors as $errors) : ?>
		<li><?php echo Lang::get('news.'.$errors); ?></li>
			<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<table class="dataset">
		<thead>
			<tr>
				<td>#</td>
				<td>Naam</td>
				<td>Aangemaakt</td>
				<td>Acties</td>
			</tr>
		</thead>
		<tbody>

			<?php foreach ($newsItems as $newsItem): ?>
			<tr>
				<td><?php echo $newsItem->getID(); ?></td>
				<td><?php echo $newsItem->getTitle(); ?></td>
				<td><?php echo date(Lang::get('product.dateformat'), strtotime($newsItem->getCreated())); ?></td>
				<td>
					<a class="button" href="<?php echo Conf::get('general.cmsurl.www'); ?>/product/edit/<?php echo $newsItem->getID(); ?>">Wijzig</a>
					<a class="button deletepage" confirm="<?php echo Lang::get('news.label.confirm-delete'); ?>" href="<?php echo Conf::get('general.cmsurl.www'); ?>/product/delete/<?php echo $newsItem->getID(); ?>"><?php echo Lang::get('product.button.deletenews'); ?></a>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>