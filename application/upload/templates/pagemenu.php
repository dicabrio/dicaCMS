<ul id="<?php echo $sMenuID; ?>">
	<?php foreach ($aMenuItems as $aItem) : ?><li class="<?php echo strtolower(str_replace(array('.', ' '), '-', $aItem['name'])); ?>"><a href="<?php echo $aItem['url']; ?>"><img src="http://dicabrio.com/text.php?text=<?php echo urlencode($aItem['name']); ?>&color=2&size=20" alt="<?php echo $aItem['name']; ?>" /></a></li><?php endforeach; ?>
</ul>