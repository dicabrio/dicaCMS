<div>
	<center>
		<table width="600" style="font-family: arial" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<img src="<?php echo $sImagesUrl; ?>/logo-mysensuality.gif" alt="MySensuality.nl - Your gift to you" />
				</td>
			</tr>
			<tr><td height="9" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="font-size: 16px; padding: 30px 0 30px 0;">
					<h2 style="font-size: 22px;">Beste <?php echo $naam; ?>,</h2>
					<p>Bedankt voor je bestelling bij MySensuality.nl!</p>
					<p>Controleer nog even je gegevens. Als er iets niet klopt, stuur dan z.s.m. een mailtje naar <a href="mailto:info@mysensuality.nl" style="color: ff479f;">info@sensuality.nl</a>.</p>
				</td>
			</tr>
			<tr>
				<td align="right" style="font-size: 13px;" height="20">Ordernummer: <?php echo $ordernummer; ?></td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="font-size: 16px; padding: 10px 0">
					<p><strong>Je gegevens</strong></p>
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="padding: 10px 0;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="font-size: 13px;">
						<tr>
							<td width="120" height="20">Naam:</td>
							<td><?php echo $naam; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
						<tr>
							<td height="20">Straat + nr.:</td>
							<td><?php echo $straat; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
						<tr>
							<td height="20">Postcode:</td>
							<td><?php echo $postcode; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
						<tr>
							<td height="20">Plaats:</td>
							<td><?php echo $plaats; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
						<tr>
							<td height="20">Land:</td>
							<td><?php echo $land; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
						<tr>
							<td height="20">Telefoon:</td>
							<td><?php echo $telefoon; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
						<tr>
							<td height="20">E-mail:</td>
							<td><?php echo $email; ?><br /></td>
						</tr>
						<tr><td colspan="2" bgcolor="ff479f" height="1"></td></tr>
					</table>
					<br />
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="font-size: 16px; padding: 10px 0">
					<p><strong>Je bestelling</strong> <span style="font-size: 12px;">(prijzen zijn in euro's, inclusief b.t.w.)</span></p>
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="padding: 20px 0;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td height="30"><strong>Artikel</strong></td>
							<td width="135"><strong>Artikelnummer</strong></td>
							<td width="70"><strong>Aantal</strong></td>
							<td width="65"><strong>Prijs</strong></td>
							<td width="90"><strong>Subtotaal</strong></td>
						</tr>
						<tr><td colspan="5" style="background-color: ff479f; height: 1px;"></td></tr>
						
						<?php foreach ($aProducts as $aProduct) : ?>
						<tr>
							<td height="30">
								<?php echo $aProduct['title']; ?> <?php foreach ($aProduct['options'] as $oValue) : ?>(<?php echo $oValue->optionvalue; ?>)<?php endforeach; ?>
							</td>
							<td>(<?php echo $aProduct['productid'] ?>)</td>
							<td><?php echo $aProduct['amount']; ?></td>
							<td><?php echo ShopUtil::formatPrice($aProduct['price']); ?> euro</td>
							<td><?php echo ShopUtil::formatPrice($aProduct['subprice']); ?> euro</td>
						</tr>
						<tr><td colspan="5" style="background-color: ff479f; height: 1px;"></td></tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="4" height="30"><strong>Verzendkosten</strong></td>
							<td><strong><?php echo ShopUtil::formatPrice($iTotalShippingCosts); ?> euro</strong></td>
						</tr>
						<tr>
							<td colspan="4" height="30"><strong>Totaal</strong></td>
							<td><strong><?php echo ShopUtil::formatPrice($iTotaal); ?> euro</strong></td>
						</tr>
					
					</table>
				
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="font-size: 16px; padding: 10px 0">
					<p><strong>Verzending</strong></p>
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="padding: 20px 0; font-size: 13px;">
					Wij verzenden je bestelling uiterlijk binnen 3 werkdagen nadat wij de betaling hebben ontvangen. Als een besteld artikel niet voorradig is, nemen we contact met je op.
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="font-size: 16px; padding: 10px 0">
					<p><strong>Betaling</strong></p>
				</td>
			</tr>
			<tr><td height="3" bgcolor="ff479f"></td></tr>
			<tr>
			<?php if ($iPayment == Order::PAYMENT_IDEAL) : ?>
				<td style="padding: 20px 0 40px; font-size: 13px;">
					Je bestelling is betaald via iDeal
				</td>
			<?php elseif ($iPayment == Order::PAYMENT_CREDITCARD) : ?>
				<td style="padding: 20px 0 40px; font-size: 13px;">
					Je bestelling is betaald via CreditCard
				</td>
			<?php elseif ($iPayment == Order::PAYMENT_PAYPAL) : ?>
				<td style="padding: 20px 0 40px; font-size: 13px;">
					Je bestelling is betaald via PayPal
				</td>
			<?php elseif ($iPayment == Order::PAYMENT_OVERBOEKING) : ?>
				<td style="padding: 20px 0; font-size: 13px;">
					<strong>Overboeken</strong><br />
					Je bestelling is nog NIET betaald.<br />
					Maak de bestelling over met behulp van onderstaande gegevens.
				</td>
			</tr>
			<tr>
				<td style="padding: 10px 0 30px;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="font-size: 13px;">
						<tr>
							<td width="120" height="20">Bedrag: </td>
							<td><?php echo ShopUtil::formatPrice($iTotaal); ?> euro</td>
						</tr>
						<tr><td colspan="2" style="background-color: ff479f; height: 1px;"></td></tr>
						<tr>
							<td height="20">Ordernummer:</td>
							<td><?php echo $ordernummer; ?></td>
						</tr>
						<tr><td colspan="2" style="background-color: ff479f; height: 1px;"></td></tr>
						<tr>
							<td height="20">Rekeningnummer:</td>
							<td><?php echo Conf::get('shop.bankaccount'); ?></td>
						</tr>
						<tr><td colspan="2" style="background-color: ff479f; height: 1px;"></td></tr>
						<tr>
							<td height="20">Ten name van:</td>
							<td>MySensuality.nl, Leiden</td>
						</tr>
						<tr><td colspan="2" style="background-color: ff479f; height: 1px;"></td></tr>
					</table>
			<?php endif; ?>
			</tr>
			<tr><td height="9" bgcolor="ff479f"></td></tr>
			<tr>
				<td style="padding: 10px 0 30px 0;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td valign="top" style="font-size: 13px;" <?php if (false) : ?>width="200"<?php endif; ?>>
								<h3 style="font-size: 16px; margin: 0 0 0 0;">MySensuality.nl</h3>
								<a href="http://www.mysensuality.nl" style="color: ff479f;">www.mysensuality.nl</a><br />
								<a href="mailto:info@mysensuality.nl" style="color: ff479f;">info@mysensuality.nl</a><br />
								
							</td>
							<?php if (false) : ?>
							<td valign="top" style="font-size: 13px;">
								<h3 style="font-size: 16px; margin: 0 0 0 0;">Nieuwsbrief ontvangen?</h3>
								<a href="http://www.mwah.nl/nieuwsbrief/<?php echo $email; ?>" style="color: ff479f;">Meld je nu aan</a>
							</td>
							<?php endif; ?>
						</tr>
					</table>
					
				</td>
		</table>
	</center>
</div>