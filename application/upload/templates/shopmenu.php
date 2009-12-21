						<ul id="shopmenu">
							<?php foreach ($aCategories as $oCategorie) : ?>
							<?php if ($iActive == $oCategorie->id) : ?>
							<li class="active">
							<?php else: ?>
							<li>
							<?php endif; ?>
								<a href="?cat=<?php echo $oCategorie->id; ?>"><?php echo $oCategorie->title; ?></a>
								<?php if ($iActive == $oCategorie->id) : ?>
								<?php if (count($aSubCategories) > 0) : ?>
								<ul>
									<?php foreach ($aSubCategories as $oSubCat) : ?>
									<?php if ($iSubActive == $oSubCat->id) : ?>
									<li class="active">
									<?php else : ?>
									<li>
									<?php endif; ?>
										<a href="?cat=<?php echo $oSubCat->id; ?>"><?php echo $oSubCat->title; ?></a></li>
									<?php endforeach; ?>
								</ul>
								<?php endif; ?>
								<?php endif; ?>
							</li>
							<?php endforeach; ?>
						</ul>