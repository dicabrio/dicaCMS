<?php if (isset($breadcrumb)) : ?>
<?php echo $breadcrumb->getContents(); ?>
<?php endif; ?>

<?php if (isset($actions)) : ?>
<?php echo $actions->getContents(); ?>
<?php endif; ?>

<?php if (isset($aErrors) && count($aErrors) > 0) : ?>
<?php foreach ($aErrors as $sError) : ?>
		<li><?php echo Lang::get($sError); ?></li>
<?php endforeach; ?>
<?php endif; ?>

		<table class="dataset">
			<thead>
				<tr>
					<td>#</td>
					<td>titel</td>
					<td>ok</td>
					<td>acties</td>
					<td>&nbsp;</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($mediaFolders as $mediaItem) : ?>
				<tr>
					<td>#</td>
					<td>
						<img src="<?php echo Conf::get('general.url.www'); ?>/images/icon-folder.png" alt="mediaitem" />
						<a href="<?php echo Conf::get('general.url.cms'); ?>/media/folder/<?php echo $mediaItem->getID(); ?>"><?php echo $mediaItem->getName(); ?></a>
					</td>
					<td>-</td>
					<td>
						<a href="<?php echo Conf::get('general.url.cms'); ?>/media/editfolder/<?php echo $mediaItem->getID(); ?>" class="button">Wijzig</a>
						<a href="<?php echo Conf::get('general.url.cms'); ?>/media/deletefolder/<?php echo $mediaItem->getID(); ?>" class="button" confirm="<?php echo Lang::get('media.suredeletefolder'); ?>">Verwijder</a>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php foreach ($mediaItems as $mediaItem) : ?>
				<tr>
					<td>#</td>
					<td><img src="<?php echo Conf::get('general.url.www'); ?>/images/icon-file.png" alt="mediaitem" /><?php echo $mediaItem->getTitle(); ?></td>
					<td><?php 
						$ok = 'v';
						try {
							$mediaItem->getFile();
						} catch (Exception $e) {
							$ok = 'x';
						}
					
						echo $ok;
						
					?></td>
					<td>
						<a href="<?php echo Conf::get('general.url.cms'); ?>/media/editmedia/<?php echo $mediaItem->getID(); ?>" class="button">Wijzig</a>
						<a href="<?php echo Conf::get('general.url.cms'); ?>/media/deletemedia/<?php echo $mediaItem->getID(); ?>" class="button" confirm="<?php echo Lang::get('media.suredeletemedia'); ?>">Verwijder</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>