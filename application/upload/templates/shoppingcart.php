<table class="totaal-tabel">
	<thead>
		<tr>
			<th colspan="5">Inhoud van uw mandje</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Product(en)</th>
			<th>Opties</th>
			<th class="price">Prijs</th>
			<th class="amount">Aantal</th>
			<th class="subtotal">Subtotaal</th>
		</tr>
		<?php foreach ($oCart->getProducts() as $oOrderItem) : ?>
			<?php $oProduct = $oOrderItem->getProduct(); ?>
			<?php $iPrice = ($oProduct->price/100); ?>
			<?php if ($oProduct->actionprice > 0) { $iPrice = ($oProduct->actionprice/100); } ?>
		<tr>
			<td><?php echo $oProduct->title; ?></td>
			<td>
					<?php foreach ((array)$oOrderItem->getOptions() as $sKey => $mOption) : ?>
						<?php if ($sKey != 'amount') : ?>
							<?php echo Lang::get('shop.'.$sKey); ?> : <?php if ($mOption instanceof OptionItem) { echo $mOption->label; } else { echo $mOption; } ?><br />
						<?php endif; ?>
					<?php endforeach; ?>
			</td>
			<td>&euro; <?php echo ShopUtil::formatPrice($iPrice); ?></td>
			<td><?php echo $oOrderItem->getAmount(); ?></td>
			<td>&euro; <?php echo ShopUtil::formatPrice($iPrice * $oOrderItem->getAmount()); ?></td>
		</tr>
		<?php endforeach; ?>
		<tr class="total-price">
			<td colspan="4">Totaalprijs incl. BTW, exclusief verzendkosten: </td>
			<td><strong>&euro; <?php echo ShopUtil::formatPrice($oCart->getTotalPrice()/100); ?></strong></td>
		</tr>
	</tbody>
</table>
<span class="button spaceright">
	<a href="<?php echo Conf::get('general.url.www'); ?>/<?php echo $sShopPage; ?>">Winkel verder</a>
</span>
<span class="button spaceright">
	<a href="<?php echo Conf::get('general.url.www'); ?>/<?php echo $sEmptyBasketPage; ?>">Leeg mandje</a>
</span>
<span class="button">
	<a href="<?php echo Conf::get('general.url.www'); ?>/<?php echo $sAccountPage; ?>">Naar de kassa</a>
</span>
