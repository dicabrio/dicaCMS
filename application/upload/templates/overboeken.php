		<div id="total-overview">
			<p>
				Je betaalt via overboeking. Met een van de onderstaande methoden kun je geld overmaken naar MySensuality.nl.
			</p>
			<table class="totaal-tabel">
				<thead>
					<tr>
						<th>Overboeking</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<p>
								Bedrag: &euro; <?php echo ShopUtil::formatPrice($iGrandTotal); ?><br />
								Ordernummer: <?php echo $iOrderNumber; ?><br />
								Rekeningnummer: <?php echo Conf::get('shop.bankaccount'); ?><br />
								Ten name van: MySensuality.nl<br />
								Woonplaats: Leiden
							</p>
							<p>
								<strong>Per post</strong><br />
								Vul een bank- of giro- overschrijvingsformulier in met bovenstaande gegevens (voorbeeld). Stuur deze per post naar je bank.
							</p>
							<p>
								<strong>Elektronisch</strong><br />
								Doormiddel van Mijn Postbank kun je het bedrag overmaken met daarbij de bovenstaande gegevens.
							</p>
							<p>
								<strong>Telefoon</strong><br />
								Indien je gebruik maakt van Postbank girofoon of Rabofoon, kunt u met de bovenstaande gegevens een overboeking doen.
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>