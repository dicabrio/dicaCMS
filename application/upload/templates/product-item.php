						<?php if ($iCount % 2 == 0) : ?>
						<div class="product">
						<?php else : ?>
						<div class="product marginright20">
						<?php endif; ?>
							<a href="?product=<?php echo $iID; ?>&cat=<?php echo $iCat; ?>"><img src="<?php echo Conf::get('general.url.upload').'/'.$sImageName; ?>" alt="Barbarelle" class="productimage" width="105" /></a>
							<h2><?php echo $sTitle; ?></h2>
							<p><a href="?product=<?php echo $iID; ?>&cat=<?php echo $iCat; ?>">Product details</a></p>
							<?php if ($iActionPrice == 0) : ?>
							<p class="price">
								Prijs: &euro; <strong><?php echo ShopUtil::formatPrice($iPrice); ?></strong><br />
							</p>
							<?php else : ?>
							<p>van: &euro; <strong><?php echo ShopUtil::formatPrice($iPrice); ?></strong></p>
							<p class="price">
								Voor: &euro; <strong><?php echo ShopUtil::formatPrice($iActionPrice); ?></strong><br />
							</p>

							<?php endif; ?>
							<form action="<?php echo $sOrderFormAction; ?>" method="post">
								<fieldset>
									<label>Aantal:</label>
									<input type="text" name="amount" value="1" class="productamount" /><br /><br />
									
									<span class="button"><input type="submit" name="submit" value="In Mandje" /></span>
									<input type="hidden" name="product" value="<?php echo $iID; ?>" />
									<input type="hidden" name="cat" value="<?php echo $iCat; ?>" />
								</fieldset>
							</form>
						</div>