	<div id="shoppingcart">
		<div id="total-overview">
			<form method="post" action="<?php echo $sPaymentMethodFormAction; ?>">
				<fieldset>
					<?php if (is_array($aErrors) && count($aErrors) > 0) : ?>
					<ul class="error">
					<?php foreach ($aErrors as $sError) : ?>
						<li><?php echo $sError; ?></li>
					<?php endforeach; ?>
					</ul>
					<?php endif; ?>
					<div>
						<label>Kies uw bank:</label>
			  			<?php echo $sIssuerselect; ?>
			  		</div>
					<p>

					<input type="hidden" name="paymentmethod" value="<?php echo Order::PAYMENT_IDEAL; ?>" />
					<input type="hidden" name="transreq" value="1" />
					</p>

					<span class="button spaceright"><a href="<?php echo Conf::get('general.url.www'); ?>/afrekenen.php" id="next" class="arrow left">Naar betaal overzicht</a><span>
					<span class="button"><input type="submit" class="arrow right" name="submit" value="Afrekenen" /></span>
			  	</fieldset>
			</form>
		</div>
	</div>
