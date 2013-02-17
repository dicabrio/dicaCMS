<ul id="<?php echo $identifier; ?>">
<?php foreach ($menuItems as $oMenuItem) : ?>
	<?php if ($oMenuItem->getIdentifier() == null) : ?><li><?php else: ?><li class="<?php echo $oMenuItem->getIdentifier(); ?>"><?php endif; ?>
		<?php if ($oMenuItem->getLink() !== false) : ?><a href="<?php echo $oMenuItem->getLink(); ?>"><?php echo $oMenuItem->getLabel(); ?></a><?php else : ?><?php echo $oMenuItem->getLabel(); ?><?php endif; ?>
	</li>
<?php endforeach; ?></ul>
