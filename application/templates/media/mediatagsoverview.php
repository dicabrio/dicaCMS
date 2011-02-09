<?php if (count($mediaItems) > 0) : ?>

<?php foreach ($mediaItems as $media) : ?>
<article>
	<header>
		<h1><?php echo $media['title']; ?></h1>
	</header>
	<p>
		<?php echo $media['description']; ?><br />
		<a href="<?php echo $media['filelocation']; ?>">Download <?php echo $media['filename']; ?></a>
		<?php if ($media['editable'] == true) : ?>
		- <a href="#">Edit</a>
		<?php endif; ?>
	</p>
</article>
<?php endforeach; ?>

<?php else : ?>
	Geen uploads gevonden
<?php endif; ?>

