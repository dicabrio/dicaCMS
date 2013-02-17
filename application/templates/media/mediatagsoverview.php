<?php if (count($mediaItems) > 0) : ?>

<?php foreach ($mediaItems as $media) : ?>
<article>
	
	<div class="download">
		<a href="<?php echo $media['filelocation']; ?>"><img src="<?php echo $media['fileicon']; ?>" alt="<?php echo $media['title']; ?>" /></a>
	</div>
	<div class="description">
		<h2><?php echo $media['title']; ?></h2>
		<p>
			<?php echo $media['description']; ?><br />
			Bestand: <a href="<?php echo $media['filelocation']; ?>"><?php echo $media['filename']; ?></a><br />
			Uploader: <?php echo $media['owner']; ?>
			<?php if ($media['editable'] == true) : ?>
			<!--- <a href="#">Edit</a>-->
			<?php endif; ?>
		</p>
	</div>
	
</article>
<?php endforeach; ?>

<?php else : ?>
	Geen uploads gevonden
<?php endif; ?>

