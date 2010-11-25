<h2>Sport &amp; Spel bestanden:</h2>
<a href="#">Bestand uploaden</a>
<hr />
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
	<!--<ul>
		<li>Linked tags (@todo)</li>
	</ul>-->
</article>
<?php endforeach; ?>

<?php else : ?>
	Geen uploads gevonden
<?php endif; ?>

<hr />

<p>Geselecteerde Tag: <?php echo $selectedTag; ?></p>
<h2>Tags:</h2>
<?php if (is_array($tags) && count($tags) > 0) : ?>
<ul>
	<?php foreach ($tags as $tag) : ?>
	<li><a href="<?php echo $wwwurl; ?>/<?php echo $pageurl; ?>.html?tag=<?php echo $tag->getName(); ?>"><?php echo $tag->getName(); ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
