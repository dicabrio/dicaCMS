<ul id="<?php echo $sMenuID; ?>">
	<?php foreach ($aMenuItems as $aItem) : ?>
		<li class="<?php echo strtolower(str_replace(array('.', ' '), '-', $aItem['name'])); ?>">
			<a href="<?php echo $aItem['url']; ?>"><?php echo $aItem['name']; ?></a>
		</li>
	<?php endforeach; ?>
</ul>