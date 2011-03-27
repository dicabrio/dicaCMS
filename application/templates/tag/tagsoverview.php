<p>Geselecteerde Tag: <strong><?php echo $selectedTag; ?></strong></p>
<h2>Tags:</h2>
<?php if (is_array($tags) && count($tags) > 0) : ?>
<ul>
	<li><a href="<?php echo $wwwurl; ?>/<?php echo $pageurl; ?>">Alles</a></li>
	<?php foreach ($tags as $tag) : ?>
	<li><a href="<?php echo $wwwurl; ?>/<?php echo $pageurl; ?>?tag=<?php echo $tag->getName(); ?>"><?php echo $tag->getName(); ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
