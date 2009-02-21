
<ul id="<?php echo $sIdentifier; ?>">
<?php foreach ($aMenuItems as $oMenuItem) : ?>
	<?php if ($oMenuItem->getIdentifier() == null) : ?><li><?php else: ?><li class="<?php echo $oMenuItem->getIdentifier(); ?>"><?php endif; ?><a href="<?php echo $oMenuItem->getLink(); ?>"><?php echo $oMenuItem->getLabel(); ?></a></li>
<?php endforeach; ?></ul>
