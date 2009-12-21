	<div id="shoppingcart">
		
		<div id="total-overview">
			<p>Op deze pagina vind je een overzicht van je bestelling en je verzendgegevens.</p>
			<?php if (is_array($aErrors) && count($aErrors) > 0) : ?>
			<ul class="error">
			<?php foreach ($aErrors as $sError) : ?>
				<li><?php echo $sError; ?></li>
			<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		
		
			<table class="totaal-tabel">
				<thead>
					<tr>
				    	<th>Factuuradres &amp; Afleveradres</th>
				    </tr>
				</thead>
				<tbody>
				    <tr>
				    	<td>
				    		<?php echo $oKlant->naam; ?><br />
				    		<?php echo $oKlant->straat; ?><br />
				    		<?php echo $oKlant->postcode; ?> <?php echo $oKlant->plaats; ?><br />
				    		<?php echo Lang::get('shop.'.$oKlant->land); ?>
				    	</td>
				    </tr>
				</tbody>
				<tfoot>
				    <tr>
				    	<td>
							<span class="button">
								<a href="<?php echo $sMijnAccountUrl; ?>" title="Uw gegevens aanpassen">Aanpassen</a>
							</span>
						</td>
					</tr>
				</tfoot>
			</table>
		
		
		
			<table class="totaal-tabel">
				<thead>
					<tr>
						<th colspan="5">Je bestelling</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th class="description">Omschrijving</th>
						<th class="amount">Aantal</th>
						<th class="price">Prijs</th>
						<th class="subtotal">Subtotaal</th>
						<th>&nbsp;</th>
					</tr>
					<?php foreach ($oCart->getProducts() as $oOrderItem) : ?>
					<tr>
						<td><?php $oProduct = $oOrderItem->getProduct(); ?>
							<?php $iPrice = ($oProduct->getPrice()/100); ?>
							<?php if ($oProduct->actionprice > 0) { $iPrice = ($oProduct->actionprice/100); } ?>
							&bull; <?php echo $oProduct->getTitle(); ?> <br/>
							<strong>
								<?php foreach ($oOrderItem->getOptions() as $sOption => $sValue) : ?>
								<?php if ($sOption != 'amount') : ?>
									<?php echo Lang::get('shop.'.$sOption); ?>: <?php echo $sValue->label; ?>, 
								<?php endif; ?>
								<?php endforeach; ?>
							</strong>
						</td>
						<td><?php echo $iAmount = $oOrderItem->getAmount(); ?></td>
						<td>&euro; <?php echo ShopUtil::formatPrice($iPrice); ?></td>
						<td>&euro; <?php echo ShopUtil::formatPrice($iPrice * $iAmount); ?></td>
						<td>&nbsp;</td>
					</tr>
					<?php endforeach; ?>
					<tr class="total-price">
						<td colspan="3"><strong>Verzendkosten: </strong></td>
						<td>&euro; <?php echo ShopUtil::formatPrice($iShippingCosts); ?></td>
						<td>&nbsp;</td>
					</tr>
					<tr class="total-price">
						<td colspan="3"><strong>Totaalprijs incl. BTW</strong></td>
						<td>&euro; <?php echo ShopUtil::formatPrice(($oCart->getTotalPrice()/100)+$iShippingCosts); ?></td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<span class="button">
								<a href="<?php echo $sMandjeUrl; ?>">Aanpassen</a>
							</span>
						</td>
					</tr>
				</tfoot>
			</table>
		
			<table class="totaal-tabel">
				<thead>
					<tr>
						<th>Belangrijk</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Als je onderaan de pagina op "afrekenen" klikt, ga je akkoord met de <a href="<?php echo $sTermsOfUserUrl; ?>" class="newwindow">algemene voorwaarden</a> en wordt de bestelling door ons verwerkt.</td>
					</tr>
				</tbody>
			</table>
		
			<form method="post" action="<?php echo $sPaymentMethodFormAction; ?>" id="paymentmethodchoice">
				<fieldset>
					<table class="totaal-tabel payments">
						<thead>
							<tr>
								<th>Betaalmethode</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>
									Kies een betaalmethode uit het menu
								</th>
							</tr>
							<?php if ($bIdealActive) : ?>
							<tr>
								<td>
									<input type="radio" name="paymentmethod" value="<?php echo Order::PAYMENT_IDEAL; ?>" />
									<img src="<?php echo $sImageUrl; ?>/ideal-logo.jpg" alt="Betalen via IDEAL" />
									Ik betaal via elektronisch bankieren (ABN-AMRO, Postbank, Rabobank, Fortis of SNS bank).
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td>
									<input type="radio" name="paymentmethod" value="<?php echo Order::PAYMENT_CREDITCARD; ?>" />
									<img src="<?php echo $sImageUrl; ?>/creditcard-logo.jpg" alt="Betalen met je creditcard" />
									Ik betaal met mijn creditcard.
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="paymentmethod" value="<?php echo Order::PAYMENT_PAYPAL; ?>" />
									<img src="<?php echo $sImageUrl; ?>/paypal-logo.jpg" alt="Betalen via paypal" />
									Ik betaal vanaf mijn PayPal rekening.
								</td>
							</tr>
							<tr>
								<td>
									<input type="radio" name="paymentmethod" value="<?php echo Order::PAYMENT_OVERBOEKING; ?>" />
									<img src="<?php echo $sImageUrl; ?>/overboeken-logo.jpg" alt="Overboeken" />
									Ik stort het te betalen bedrag op de rekening van MySensuality.nl. Na ontvangst van het bedrag verzendt MySensuality.nl de bestelling.
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td>
									<span class="button">
										<input type="submit" class="arrow right" name="submit" value="Afrekenen" />
									</span>
								</td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
			</form>
		</div>
	</div>
