<fieldset>
	<legend>Adresgegevens huis</legend>
	<div>
		<div>
    		Controleer of je huis al op hartvoorwonen staat.
			<br /><br />
        	Vul hieronder de postcode en huisnummer (toevoeging) combinatie in van het huis dat je te koop/te huur wilt zetten.
		</div>

		<form name="address">
			<table>
				<tr>
					<td>Postcode</td>
					<td>Huisnummer</td>
					<td>Toevoeging</td>
				</tr>
				<tr>
					<td><input type="text" name="zipcode" /></td>
					<td><input type="text" name="housenumber" /></td>
					<td><input type="text" name="housenumberadd" /></td>
				</tr>
			</table>
		</form>
	</div>

	<div>
		<div>Selecteer je huis uit de onderstaande lijst</div>
		<br /><br />
	</div>

	<div>
		<p>
    		Bevestig dat jij de eigenaar bent van dit huis:
		</p>
		<p>
			Na bevestiging kan je informatie over het huis toevoegen, de woningwaarde verbeteren en je woning
			te koop of te huur aanbieden.
		</p>
		<div>
			<b>Let op!</b> Dit huis staat al te koop of te huur op JAAP.NL. Door zelf een aanbieding van dit huis te maken
    					overschrijf je de gegevens van de makelaar. Overleg eerst met je makelaar voordat je verder gaat.
			<br /><br />

		</div>

	</div>

	<div>
        <p>Vul hieronder de postcode en huisnummer (toevoeging) combinatie in van het huis dat je te koop/te huur wilt zetten.</p>
		<table class="zoek_mijn_huis_form">
			<tr>
				<td>Postcode</td>
				<td>Huisnummer</td>
				<td>Toevoeging</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="zipcode" />
				</td>
				<td>
					<input type="text" name="houseNumber" />
				</td>
				<td>
					<input type="text" name="houseNumberAddition" />
				</td>
			</tr>
		</table>
	</div>

</fieldset>
<fieldset>
	<legend>Contactgegevens eigenaar</legend>
	<p>Vul hieronder uw gegevens in zodat ge&iuml;nteresseerden contact met u kunnen opnemen.</p>
	<table>
		<tr>
			<td>Voornaam:</td>
			<td><input type="text" name="contactFirstName" value="" /></td>
		</tr>
		<tr>
			<td>Tussenvoegsel:</td>
			<td><input type="text" name="contactLastNamePrefix" value="" /></td>
		</tr>
		<tr>
			<td>Achternaam:</td>
			<td><input type="text" name="contactLastName" value="" /></td>
		</tr>
		<tr>
			<td>Emailadres:</td>
			<td><input type="text" disabled="disabled" name="email" value="" /></td>
		</tr>
		<tr>
			<td>Telefoonnummer:</td>
			<td><input type="text" name="contactPhoneNumber" value="" /></td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<legend>Kenmerken algemeen</legend>

	<p>Vul hieronder de algemene kenmerken van je huis in.</p>

	<table>
		<tr>
			<td>Woningtype:</td>
			<td>
				<select name="propertytype">
					<option value="" >Maak een keuze...</option>
					<option value="Tussenwoning" >Tussenwoning</option>
					<option value="Hoekwoning" >Hoekwoning</option>
					<option value="Twee onder een kap" >Twee onder &eacute;&eacute;n kap</option>
					<option value="Vrijstaande woning" >Vrijstaande woning</option>
					<option value="Geschakelde woning" >Geschakelde woning</option>
					<option value="Eengezinswoning" >Eengezinswoning</option>
					<option value="Appartement" >Appartement</option>
					<option value="Woning" >Woning</option>
					<option value="Penthouse" >Penthouse</option>
					<option value="Villa" >Villa</option>
					<option value="Woonboerderij" >Woonboerderij</option>
					<option value="Bungalow" >Bungalow</option>
					<option value="Herenhuis" >Herenhuis</option>
					<option value="Landhuis" >Landhuis</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Bouwjaar:</td>
			<td>
				<input type="text" name="yearbuilt" value="" />
			</td>
		</tr>
		<tr>
			<td>Perceeloppervlak:</td>
			<td>
				<input type="text" name="lotSize" value=""/> m&sup2;
			</td>
		</tr>
		<tr>
			<td>Woonoppervlak:</td>
			<td>
				<input type="text" name="floorSpace" value=""/> m&sup2;
			</td>
		</tr>
		<tr>
			<td>Inhoud:</td>
			<td>
				<input type="text" name="volume" value=""/> m&sup3;<br />
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="value">Als je de inhoud van je huis niet weet, neem dan het woonoppervlak en vermenigvuldig dit met 2.5<br /><br /></td>
		</tr>
		<tr>
			<td>Gestoffeerd:</td>
			<td>
				<input type="radio" name="decorated" value="true"  />&nbsp;Ja&nbsp;&nbsp;
				<input type="radio" name="decorated" value="false" checked="checked" />&nbsp;Nee
			</td>
		</tr>
		<tr>
			<td>Gemeubileerd:</td>
			<td>
				<input type="radio" name="furnished" value="true"  />&nbsp;Ja&nbsp;&nbsp;
				<input type="radio" name="furnished" value="false" checked="checked" />&nbsp;Nee
			</td>
		</tr>
		<tr>
			<td>Aantal kamers:</td>
			<td>
				<input type="text" name="numberOfRooms" value=""/>
			</td>
		</tr>
		<tr>
			<td class="name">Aantal dakkapellen:</td>
			<td class="value">
				<input type="text" name="numberOfDormers" class="shaded numeric" value=""/>
			</td>
		</tr>
		<tr>
			<td class="name">Garage:</td>
			<td class="value">
				<input type="radio" id="garageYes" name="garage" value="true"  />&nbsp;Ja&nbsp;&nbsp;
				<input type="radio" id="garageNo" name="garage" value="false" checked />&nbsp;Nee
			</td>
		</tr>
		<tr>
			<td class="name">Zwembad:</td>
			<td class="value">
				<input type="radio" id="swimmimgPoolYes" name="swimmingPool" value="true"  />&nbsp;Ja&nbsp;&nbsp;
				<input type="radio" id="swimmingPoolNo" name="swimmingPool" value="false" checked />&nbsp;Nee
			</td>
		</tr>
		<tr>
			<td class="name">Balkon:</td>
			<td class="value">
				<input type="radio" id="balconyYes" name="balcony" value="true"  />&nbsp;Ja&nbsp;&nbsp;
				<input type="radio" id="balconyNo" name="balcony" value="false" checked />&nbsp;Nee
			</td>
		</tr>
		<tr>
			<td class="name">Lift:</td>
			<td class="value">
				<input type="radio" id="elevatorYes" name="elevator" value="true"  />&nbsp;Ja&nbsp;&nbsp;
				<input type="radio" id="elevatorNo" name="elevator" value="false" checked />&nbsp;Nee
			</td>
		</tr>
	</table>
</fieldset>
<div class="mijnjaap_slidepane" id="kenmerkenbinnen">
	<div class="mijnjaap_slidepane_header"><div class="mijnjaap_plusmin"></div>Kenmerken binnen</div>
	<div class="mijnjaap_slidepane_content" style="display: none;">
		<div class="mijnjaap_slidepane_content_holder">
			<div class="mijnjaap_form_fout" id="kenmerkenbinnen_errors" style="display:none"><ul></ul></div>
			<div><p>Vul hieronder de kenmerken van de binnenkant van je huis in.</p></div>
			<div class="customer_listing_form">


				<form name="kenmerkenbinnen_form" id="kenmerken_binnen_form">
					<table>
						<tr>
							<td class="name">Type keuken:</td>
							<td class="value">
								<select name="kitchen" class="shaded">
									<option value="" >Maak een keuze...</option>
									<option value="Luxurious" >Luxe</option>
									<option value="Modern" >Moderne</option>
									<option value="New" >Nieuwe</option>
									<option value="Standard" >Standaard</option>
									<option value="OutDated" >Verouderde</option>
									<option value="None" >Geen</option>
								</select>
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Hoofdverwarming:</td>
							<td class="value">
								<input type="checkbox" name="blockOrDistrictHeating" value="true"  />&nbsp;Stadsverwarming
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="centralHeating" value="true"  />&nbsp;Centrale-verwarming
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="centralHeatingHighYield" value="true"  />&nbsp;CV hoogrendement
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="gasHeater" value="true"  />&nbsp;Gaskachel
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Bijverwarming:</td>
							<td class="value">
								<input type="checkbox" name="hotAir" value="true"  />&nbsp;Hete lucht
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="firePlace" value="true"  />&nbsp;Open haard
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="floorHeating" value="true"  />&nbsp;Vloerverwarming
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Sanitair:</td>
							<td class="value">
								<input type="checkbox" name="secondBathroom" value="true"  />&nbsp;2e badkamer
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="secondToilet" value="true"  />&nbsp;2e toilet
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="bathtub" value="true"  />&nbsp;Bad
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="sauna" value="true"  />&nbsp;Sauna
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Isolatie:</td>
							<td class="value">
								<input type="checkbox" name="roofIsolation" value="true"  />&nbsp;Dak
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="doubleGlassed" value="true"  />&nbsp;Dubbel glas
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="wallIsolation" value="true"  />&nbsp;Muren
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Staat van onderhoud binnen:</td>
							<td class="value">
								<select name="maintenanceStateIndoors">
									<option value="" >Maak een keuze...</option>
									<option value="Bad" >Slecht</option>
									<option value="Mediocre" >Matig</option>
									<option value="Reasonable" >Redelijk</option>
									<option value="Good" >Goed</option>
									<option value="Excellent" >Uitstekend</option>
								</select>
							</td>
						</tr>
					</table>

				</form>

				<div class="common_button mijnjaap_cb_margin" id="kenmerken_binnen_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Kenmerken binnen opslaan</div>
					<div class="cb_right"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mijnjaap_slidepane" id="kenmerkenbuiten">
	<div class="mijnjaap_slidepane_header"><div class="mijnjaap_plusmin"></div>Kenmerken buiten</div>
	<div class="mijnjaap_slidepane_content" style="display: none;">
		<div class="mijnjaap_slidepane_content_holder">
			<div class="mijnjaap_form_fout" id="kenmerkenbuiten_errors" style="display:none"><ul></ul></div>
			<div><p>Vul hieronder de kenmerken van de buitenkant van je huis in.</p></div>
			<div class="customer_listing_form">


				<form name="kenmerkenbuiten_form" id="kenmerken_buiten_form">
					<table>
						<tr>
							<td class="name">Tuin:</td>
							<td class="value">
								<input type="radio" id="gardenYes" name="garden" value="true"  />&nbsp;Ja&nbsp;&nbsp;
								<input type="radio" id="gardenNo" name="garden" value="false" checked />&nbsp;Nee
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="gardenFront" id="gardenFront_checkbox" value="true"  />&nbsp;Voorkant
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="gardenBack" id="gardenBack_checkbox" value="true"  />&nbsp;Achterkant
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="gardenSide" id="gardenSide_checkbox" value="true"  />&nbsp;Zijkant
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Uitzicht op:</td>
							<td class="value">
								<input type="checkbox" name="viewOrchard" value="true"  />&nbsp;Boomgaard
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewForest" value="true"  />&nbsp;Bos
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewDike" value="true"  />&nbsp;Dijk
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewTownCanal" value="true"  />&nbsp;Gracht
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewGreennesSupplies" value="true"  />&nbsp;Groenvoorzieningen
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewPort" value="true"  />&nbsp;Haven
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewMetro" value="true"  />&nbsp;Metrolijn
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewPublicGarden" value="true"  />&nbsp;Park
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewWater" value="true"  />&nbsp;Water
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewMeadow" value="true"  />&nbsp;Weiland
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewCommercial" value="true"  />&nbsp;Winkels
							</td>
						</tr>
						<tr>
							<td class="name">&nbsp;</td>
							<td class="value">
								<input type="checkbox" name="viewResidential" value="true"  />&nbsp;Woningen
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td class="name">Staat van onderhoud buiten:</td>
							<td class="value">
								<select name="maintenanceStateOutdoors" class="shaded">
									<option value="" >Maak een keuze...</option>
									<option value="Bad" >Slecht</option>
									<option value="Mediocre" >Matig</option>
									<option value="Reasonable" >Redelijk</option>
									<option value="Good" >Goed</option>
									<option value="Excellent" >Uitstekend</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="name">Staat van onderhoud schilderwerk:</td>
							<td class="value">
								<select name="maintenanceStatePaintwork" class="shaded">
									<option value="" >Maak een keuze...</option>
									<option value="Bad" >Slecht</option>
									<option value="Mediocre" >Matig</option>
									<option value="Reasonable" >Redelijk</option>
									<option value="Good" >Goed</option>
									<option value="Excellent" >Uitstekend</option>
								</select>
							</td>
						</tr>
					</table>
				</form>

				<div class="common_button mijnjaap_cb_margin" id="kenmerken_buiten_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Kenmerken buiten opslaan</div>
					<div class="cb_right"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mijnjaap_slidepane" id="omschrijving">
	<div class="mijnjaap_slidepane_header"><div class="mijnjaap_plusmin"></div>Omschrijving</div>
	<div class="mijnjaap_slidepane_content" style="display: none;">
		<div class="mijnjaap_slidepane_content_holder">
			<div class="mijnjaap_form_fout" id="omschrijving_errors" style="display:none"><ul></ul></div>
			<div>
   				Je kunt hieronder een omschrijving van je huis geven (minimaal 500, maximaal 5000 tekens).
   				Probeer in de omschrijving een zo goed mogelijke, aantrekkelijke omschrijving van alle
   				ruimtes in je huis te geven. Probeer ook uit te leggen waarom iemand jouw huis zou moeten kopen.
			</div>
			<br />

			<div class="customer_listing_form">

				<form name="omschrijving_form" id="omschrijving_form">
					<span id="charCounter">0</span> <b>/ 5000</b>
					<textarea name="description" id="description_textarea"></textarea>
				</form>
				<b>
    				Let op: Door op de knop "Omschrijving opslaan" te klikken verklaar ik dat ik de schrijver
    				van deze tekst ben, de auteursrechten op deze tekst behoren mijn toe. Ik heb de tekst
    				dan ook niet van andere rechthebbende gekopieerd.
				</b>

				<div class="common_button mijnjaap_cb_margin" id="omschrijving_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Omschrijving opslaan</div>
					<div class="cb_right"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mijnjaap_slidepane" id="waardering_prijs">
	<div class="mijnjaap_slidepane_header"><div class="mijnjaap_plusmin"></div>Waardering en prijs</div>
	<div class="mijnjaap_slidepane_content" style="display: none;">
		<div class="mijnjaap_slidepane_content_holder">
			<div class="mijnjaap_form_fout" id="waardering_prijs_errors" style="display:none"><ul></ul></div>

			<div id="wp_koop" style="display:none;">
				Hier kun je de vraagprijs van je huis opgeven. Probeer hierbij een realistische prijs te vragen.
				<span id="wp_koop_wwi" style="display:none;">
				    Als leidraad hebben wij een grove inschatting gemaakt van wat je huis waard kan zijn.
				    Ook kun je naar
				</span>
				<span id="wp_koop_no_wwi" style="display:none;">
				    Als leidraad kun je naar
				</span>
				<a id="wp_a_koop" target="_blank" href="/?action=search&search_input=">huizen in de omgeving</a> kijken om je een beeld te vormen van wat je mogelijk zou kunnen vragen.
				Als je een goed beeld hebt kun je hieronder de vraagprijs van je huis invullen.
				<br /><br/>

				<div id="wp_koop_wwi_min_max" style="display:none;">
					Het Nederlands Bureau Waardebepaling Onroerendzaken (NBWO) heeft met behulp van algemeen beschikbare gegevens van onder andere het Kadaster een
					INSCHATTING gemaakt van wat de waarde van dit huis zou kunnen zijn.
					<br /><br /><br />

					De door het NBWO geschatte waarde van dit huis is:<br />
					&euro; <b><span id="wwi_min"></span> - &euro; <span id="wwi_max"></span></b>
				</div>
			</div>

			<div id="wp_huur" style="display:none;">
						Hier kun je  de  huurprijs (per maand) van je huis opgeven. Probeer hierbij een realistische prijs te vragen. Als
						leidraad  kun je naar <a id="wp_a_huur" target="_blank" href="/?action=search&search_type=rent&search_input=">huizen  in  de  omgeving</a> kijken om je een beeld te vormen van wat je mogelijk
						zou kunnen vragen. Als je een goed beeld hebt kun je hieronder de huurprijs van je huis invullen.
			</div>

			<br />

			<div class="customer_listing_form">

				<form name="waardering_prijs_form" id="waardering_prijs_form">
    				De <span id="wp_koop_price">vraagprijs</span><span id="wp_huur_price">huurprijs</span> voor mijn woning is: &euro;&nbsp;
					<input type="text" class="shaded" name="price" id="price_text"  /><span id="wp_huur_price_2"> per maand</span>
				</form>

				<div class="common_button mijnjaap_cb_margin" id="waardering_prijs_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Prijs opslaan</div>
					<div class="cb_right"></div>
				</div>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/js/lib/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/js/lib/swfupload/swfupload.swfobject.js"></script>
<script type="text/javascript" src="/js/lib/swfupload/swfupload.queue.js"></script>

<div class="mijnjaap_slidepane" id="fotos">
	<div class="mijnjaap_slidepane_header"><div class="mijnjaap_plusmin"></div>Foto's</div>
	<div class="mijnjaap_slidepane_content" style="display: none;">

		<div class="mijnjaap_slidepane_content_holder" id="flash_upload" >
			<div class="mijnjaap_form_fout" id="fotos_errors" style="display:none"><ul></ul></div>

			<div id="foto_upload">
				<p>
   					In dit blok kun je ervoor zorgen dat jouw huis zo goed mogelijk gepresenteerd
					wordt met foto's. Zorg ervoor dat je met de foto's die je toevoegt aan je
					huis ge&iuml;nteresseerden een zo goed mogelijk beeld van je huis geeft. Je kunt
					maximaal 15 foto's toevoegen (van max 5MB).
				</p>
				<p>
   					Het vinkje onder de foto geeft aan welke foto de hoofdfoto is.<br />
   					Door op het prullenbakje te klikken verwijder je de foto.
				</p>
				<p>
   					Het is mogelijk om meerdere foto's tegelijkertijd te selecteren en in &eacute;&eacute;n keer toe te voegen
				</p>

				<div id="fotoContainer">
					<div id="choose_photo_message" style="display: none">Kies een foto</div>

				</div>

				<div id="swf_upload_holder">
					<div class="common_button mijnjaap_cb_margin" id="select_fotos" style="float: left">
						<div class="cb_left"></div>
						<div class="cb_center">Foto's kiezen</div>
						<div class="cb_right"></div>
					</div>
					<a style="float:right; margin-right: 40px; padding: 5px 0 6px 0" href="javascript:loadAlternativeUpload();">Alternatieve upload mogelijkheid</a>
				</div>

				<div id="alternative_upload" style="display:none">
					<form id="alternative_upload_form" method="post" action="/mijn-jaap/dhz/fotos/" enctype="multipart/form-data" target="photoTarget">
						<input type="hidden" name="jscallback" value="photoUploadReady" />
						<div class="foto_toevoegen_tekst">Foto toevoegen:</div>
						<input type="file" name="photo" id="photo_input" size="40" />
					</form>
					<iframe id="photoTargetIframe" name="photoTarget" style="display:none"></iframe>
				</div>

			</div>

			<b>
    			Let op: Door op de knop "Foto's opslaan" te klikken verklaar ik dat ik de maker
    			van dit foto materiaal ben, de auteursrechten op deze materialen behoren mij toe.
    			Ik heb de foto's dan ook niet van andere rechthebbende gekopieerd.
			</b>
			<br />

			<div class="common_button mijnjaap_cb_margin" id="fotos_submit">
				<div class="cb_left"></div>
				<div class="cb_center">Foto's opslaan</div>
				<div class="cb_right"></div>
			</div>
		</div>

	</div>
</div>



<div class="mijnjaap_slidepane" id="publiceren">
	<div class="mijnjaap_slidepane_header"><div class="mijnjaap_plusmin"></div>Publiceren</div>
	<div class="mijnjaap_slidepane_content" style="display: none;">
		<div class="mijnjaap_slidepane_content_holder">
			<div class="mijnjaap_form_fout" id="publiceren_errors" style="display:none"><ul></ul></div>
			<div>

				<form name="publiceren_form" id="publiceren_form" class="customer_listing_form">
					<table>
						<tr>
							<td id="general_conditions"><input type="checkbox" name="generalConditionsOk" id="general_conditions_agreed" value="true" /></td>
							<td>
    							Ik ga akkoord met de <a target="_blank" href="http://www2.jaap.nl/voorwaarden/">algemene voorwaarden</a> van JAAP.NL en verklaar dat ik de eigenaar ben van het huis dat ik nu <span id="publiceren_market"></span> ga zetten.
							</td>
						</tr>
					</table>
				</form>

				<div class="common_button mijnjaap_cb_margin cb_disabled" id="publiceren_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Woning publiceren</div>
					<div class="cb_right"></div>
				</div>

				<div class="common_button mijnjaap_cb_margin" id="withdraw_customer_listing_rent_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Woning definitief verwijderen</div>
					<div class="cb_right"></div>
				</div>

				<div class="common_button mijnjaap_cb_margin" id="withdraw_customer_listing_sale_submit">
					<div class="cb_left"></div>
					<div class="cb_center">Woning definitief verwijderen</div>
					<div class="cb_right"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Withdraw message dialog -->
<div id="withdraw_message_box" class="help_content" style="display:none">
	<div class="border">
		<p><b>Weet je zeker dat je de aanbieding van dit huis op JAAP.NL wilt verwijderen?</b></p>
		<p><b>De aanbieding wordt verwijderd uit je profiel en alle gegevens gaan dan verloren.</b></p>
		<br/><br />
		<div class="common_button mijnjaap_cb_margin" id="withdraw_customer_listing_yes">
			<div class="cb_left"></div>
			<div class="cb_center">Ja</div>
			<div class="cb_right"></div>
		</div>
		<div class="common_button mijnjaap_cb_margin" id="withdraw_customer_listing_no">
			<div class="cb_left"></div>
			<div class="cb_center">Nee</div>
			<div class="cb_right"></div>
		</div>
	</div>
</div>