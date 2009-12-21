						<?php if ($iCount % 2 == 0) : ?>
						<div class="product category">
						<?php else : ?>
						<div class="product marginright20 category">
						<?php endif; ?>
							<a href="?cat=<?php echo $iID; ?>"><img src="<?php echo Conf::get('general.url.upload').'/'.$sImageName; ?>" alt="<?php echo $sTitle; ?>" class="categoryimage" width="105" /></a>
							<h2><?php echo $sTitle; ?></h2>
							<p>
								<?php echo $sDescription; ?><br />
								<a href="?cat=<?php echo $iID; ?>">Naar de producten</a>
							</p>
						</div>