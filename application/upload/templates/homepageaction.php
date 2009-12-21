<img src="<?php echo $sImagename; ?>" alt="<?php echo $sTitle; ?>" width="105" class="productimage" />
<h2><img src="http://dicabrio.com/text.php?text=<?php echo $sTitle; ?>&color=1" alt="<?php echo $sTitle; ?>" /></h2>
<p><?php echo $sDescription; ?> <a href="<?php echo $sWwwUrl; ?>/shop.php?cat=<?php echo $iCat; ?>&amp;product=<?php echo $iProductID; ?>">Lees meer</a></p>
<p class="price">nu: <strong>&euro; <?php echo ShopUtil::formatPrice($iActionPrice); ?></strong></p>
<img src="images/attention-actie.gif" alt="Actie" class="small-attention" />
<span class="button"><a href="<?php echo $sWwwUrl; ?>/shop.php?cat=<?php echo $iCat; ?>&amp;product=<?php echo $iProductID;  ?>">In mandje</a></span>