                                                         

MySensuality.nl | Your gift to you

########################################################################################################

Beste <?php echo $naam; ?>,

Bedankt voor je bestelling bij MySensuality.nl!
Controleer nog even je gegevens. Als er iets niet klopt, stuur dan z.s.m een mailtje
naar info@mysensuality.nl.

========================================================================================================
Je gegevens
========================================================================================================

Naam: 			<?php echo $naam."\n"; ?>
--------------------------------------------------------------------------------------------------------
Straat + nr.:	<?php echo $straat."\n"; ?>
--------------------------------------------------------------------------------------------------------
Postcode: 		<?php echo $postcode."\n"; ?>
--------------------------------------------------------------------------------------------------------
Plaats: 		<?php echo $plaats."\n"; ?>
--------------------------------------------------------------------------------------------------------
Land: 			<?php echo $land."\n"; ?>
--------------------------------------------------------------------------------------------------------
Telefoon: 		<?php echo $telefoon."\n"; ?>
--------------------------------------------------------------------------------------------------------
E-mail:			<?php echo $email."\n"; ?>
--------------------------------------------------------------------------------------------------------

<?php echo sprintf("%104s\n", "Ordernummer: ".$ordernummer); ?>
========================================================================================================
Je bestelling (prijzen zijn in euro's, inclusief b.t.w)
========================================================================================================

Artikel                                                   Artikelnummer   Aantal   Prijs   Subtotaal
--------------------------------------------------------------------------------------------------------
<?php foreach ($aProducts as $aProduct) { 
	 echo sprintf("%-58s%-16s%-9d%-8s%-13s\n", 
	 							$aProduct['title'],
	 							'('.$aProduct['productid'].')', 
	 							$aProduct['amount'], 
	 							ShopUtil::formatPrice($aProduct['price']).' euro',
	 							ShopUtil::formatPrice($aProduct['subprice']).' euro'); 
?> 
--------------------------------------------------------------------------------------------------------
<?php } 
echo sprintf("%-91s%-13s\n", 'Verzendkosten', ShopUtil::formatPrice($iTotalShippingCosts).' euro'); ?>
--------------------------------------------------------------------------------------------------------
echo sprintf("%-91s%-13s\n", 'Totaal', ShopUtil::formatPrice($iTotaal).' euro'); ?>

========================================================================================================
Verzending
========================================================================================================

Wij verzenden je bestelling uiterlijk binnen 3 werkdagen nadat wij de betaling hebben ontvangen. Als een besteld artikel niet voorradig is, 
nemen we contact met je op.

========================================================================================================
Betaling
========================================================================================================

<?php if ($iPayment == Order::PAYMENT_IDEAL) : ?>
Je bestelling is betaald via iDeal  
<?php elseif ($iPayment == Order::PAYMENT_CREDITCARD) : ?>
Je bestelling is betaald via CreditCard  
<?php elseif ($iPayment == Order::PAYMENT_PAYPAL) : ?>
Je bestelling is betaald via PayPal  
<?php elseif ($iPayment == Order::PAYMENT_OVERBOEKING) : ?>
Je hebt gekozen voor overboeken. Maak het onderstaande bedrag over o.v.v. het ordernummer.
					
Bedrag: <?php echo ShopUtil::formatPrice($iTotaal); ?> euro  
Ordernummer: <?php echo $ordernummer; ?>
Rekeningnummer: <?php echo Conf::get('shop.bankaccount'); ?>
Ten name van: MySensuality.nl
Woonplaats: Leiden
<?php endif; ?>

########################################################################################################

<?php if (false) : ?> 
Mwah							Nieuwsbrief ontvangen?
http://www.mysensuality.nl		http://www.mwah.nl/nieuwsbrief/<?php echo $email."\n"; ?>
info@mysensuality.nl
http://twitter.com/MwahNL
<?php endif; ?> 
MySensuality.nl
http://www.mysensuality.nl
info@mysensuality.nl


