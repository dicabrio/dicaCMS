				<div class="product-details">
					<img src="<?php echo Conf::get('general.url.upload'); ?>/<?php echo $sInzetName; ?>" width="150" alt="" class="productimage" />
					<div class="details">
						<h2><?php echo $sPageTitle; ?></h2>
						<?php if ($iActionPrice == 0) : ?>
						<p class="price">
							&euro; <strong><?php echo ShopUtil::formatPrice($iPrice); ?></strong><br />
						</p>
						<?php else : ?>
						<p>van: &euro; <strong><?php echo ShopUtil::formatPrice($iPrice); ?></strong></p>
						<p class="price">
							Voor: &euro; <strong><?php echo ShopUtil::formatPrice($iActionPrice); ?></strong><br />
						</p>

						<?php endif; ?>
						<form name="addProduct" method="post" action="<?php echo Conf::get('general.url.www'); ?>/shop.php">							
							<fieldset>
							<ul class="productoptions">
								<li>
									<input type="text" name="amount" value="1">
								</li>
								<?php foreach ($aOptions as $oOption) : ?>
									<?php echo $oOption->getContents(); ?>
								<?php endforeach; ?>
								<li>
									<input type="hidden" name="product" value="<?php echo $iProductID; ?>">
									<input type="hidden" name="cat" value="<?php echo $iCatID; ?>">
									<span class="button"><input type="submit" name="add" id="addbutton" value="Stop in mandje" /></span>
								</li>
							</ul>
							</fieldset>
						</form>
						<?php if (!empty($sDescription)) : ?>
						<p><?php echo $sDescription; ?></p>
						<?php endif; ?>
						
						
					</div>
					<a href="<?php echo Conf::get('general.url.www'); ?>/shop.php?cat=<?php echo $iCatID; ?>"><< Terug naar de winkel</a>
					<div class="clear">&nbsp;</div>
				</div>