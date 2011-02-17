<form action="#">
	<ul id="tabmenu">
		<li class="active"><a href="#adresgegevens" class="adresgegevens">Adres</a></li>
		<!--<li><a href="#contactgegevens" class="contactgegevens">Contact</a></li>-->
		<li><a href="#kenmerken" class="kenmerken">Kenmerken</a></li>
		<li><a href="#omschrijving" class="omschrijving">Omschrijving</a></li>
		<li><a href="#waardering" class="waardering">Waardering en prijs</a></li>
		<li><a href="#fotos" class="fotos">Foto's</a></li>
		<li><a href="#publiceren" class="publiceren">Publiceren</a></li>
	</ul>
	<div class="tab" id="adresgegevenstab">
		<fieldset>
			<legend>Adresgegevens huis</legend>

			<div class="middle">
				<p>
					Controleer of je huis al op hartvoorwonen staat.<br />
					Vul hieronder de postcode en huisnummer (toevoeging) combinatie in van het huis dat je te koop/te huur wilt zetten.
				</p>

				<table class="formtable">
					<tr>
						<th><label for="postcode">Postcode</label></th>
						<td><input type="text" name="postcode" id="postcode" value="" /></td>
					</tr>
					<tr>
						<th><label for="huisnummer">Huisnummer</label> + <label for="toevoeging">toevoeging</label></th>
						<td><input type="text" name="huisnummer" id="huisnummer" value="" /><input type="text" name="toevoeging" id="toevoeging" value="" /></td>
					</tr>
				</table>
			</div>

			<!--			<div>
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
			-->
			<div class="actions">
				<table class="formtable">
					<tr>
						<th>&nbsp;</th>
						<td><a href="#kenmerken" class="button">volgende stap</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	<!--<div class="tab" id="contactgegevenstab">
		<fieldset>
			<legend>Contactgegevens eigenaar</legend>
			<div class="middle">
				<p>Vul hieronder uw gegevens in zodat ge&iuml;nteresseerden contact met u kunnen opnemen.</p>
				<table class="formtable">
					<tr>
						<th><label for="voornaam">Voornaam:</label></th>
						<td><input type="text" name="voornaam" id="voornaam" value="" /></td>
					</tr>
					<tr>
						<th><label for="tussenvoegsel">Tussenvoegsel:</label></th>
						<td><input type="text" name="tussenvoegsel" id="tussenvoegsel" value="" /></td>
					</tr>
					<tr>
						<th><label for="achternaam">Achternaam:</label></th>
						<td><input type="text" name="achternaam" id="achternaam" value="" /></td>
					</tr>
					<tr>
						<th><label for="email">Emailadres:</label></th>
						<td><input type="text" name="email" id="email" value="" /></td>
					</tr>
					<tr>
						<th><label for="telefoon">Telefoonnummer:</label></th>
						<td><input type="text" name="telefoon" id="telefoon" value="" /></td>
					</tr>
				</table>
			</div>
			<div class="actions">
				<table class="formtable">
					<tr>
						<th><a href="#adresgegevens" class="linkbutton">vorige stap</a></th>
						<td><a href="#kenmerken" class="button">volgende stap</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>-->
	<div class="tab" id="kenmerkentab">
		<fieldset>
			<legend>Kenmerken</legend>

			<div class="middle">
				<p>Vul hieronder de algemene kenmerken van je huis in.</p>

				<table class="formtable">
					<tr>
						<th><label>Woningtype:</label></th>
						<td>
							<select name="propertytype">
								<option value="" >Maak een keuze...</option>
								<option value="Tussenwoning">Tussenwoning</option>
								<option value="Hoekwoning">Hoekwoning</option>
								<option value="Twee onder een kap">Twee onder &eacute;&eacute;n kap</option>
								<option value="Vrijstaande woning">Vrijstaande woning</option>
								<option value="Geschakelde woning">Geschakelde woning</option>
								<option value="Eengezinswoning">Eengezinswoning</option>
								<option value="Appartement">Appartement</option>
								<option value="Woning">Woning</option>
								<option value="Penthouse">Penthouse</option>
								<option value="Villa">Villa</option>
								<option value="Woonboerderij">Woonboerderij</option>
								<option value="Bungalow">Bungalow</option>
								<option value="Herenhuis">Herenhuis</option>
								<option value="Landhuis">Landhuis</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>Bouwjaar:</th>
						<td>
							<?php echo $form->getFormElement('bouwjaar'); ?>
						</td>
					</tr>
					<tr>
						<th>Perceeloppervlak:</th>
						<td>
							<?php echo $form->getFormElement('perceeloppervlak'); ?> m&sup2;
						</td>
					</tr>
					<tr>
						<th>Woonoppervlak:</th>
						<td>
							<?php echo $form->getFormElement('woonoppervlak'); ?> m&sup2;
						</td>
					</tr>
					<tr>
						<th>Inhoud:</th>
						<td>
							<?php echo $form->getFormElement('inhoud'); ?> m&sup3;<br />
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>Als je de inhoud van je huis niet weet, neem dan het woonoppervlak en vermenigvuldig dit met 2.5<br /><br /></td>
					</tr>
					<tr>
						<th>Gestoffeerd:</th>
						<td>
							<?php echo $form->getFormElement('gestoffeerd_0'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('gestoffeerd_1')->addAttribute('checked', 'checked'); ?>&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Gemeubileerd:</th>
						<td>
							<?php echo $form->getFormElement('gemeubileerd_0'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('gemeubileerd_1')->addAttribute('checked', 'checked'); ?>&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Aantal kamers:</th>
						<td>
							<input type="text" name="numberOfRooms" value=""/>
						</td>
					</tr>
					<tr>
						<th>Aantal dakkapellen:</th>
						<td>
							<input type="text" name="numberOfDormers" value=""/>
						</td>
					</tr>
					<tr>
						<th>Garage:</th>
						<td>
							<input type="radio" name="garage" value="true"  />&nbsp;Ja&nbsp;&nbsp;
							<input type="radio" name="garage" value="false" checked />&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Zwembad:</th>
						<td>
							<input type="radio" name="swimmingPool" value="true"  />&nbsp;Ja&nbsp;&nbsp;
							<input type="radio" name="swimmingPool" value="false" checked />&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Balkon:</th>
						<td>
							<input type="radio"name="balcony" value="true"  />&nbsp;Ja&nbsp;&nbsp;
							<input type="radio"name="balcony" value="false" checked />&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Lift:</th>
						<td>
							<input type="radio" name="elevator" value="true"  />&nbsp;Ja&nbsp;&nbsp;
							<input type="radio" name="elevator" value="false" checked />&nbsp;Nee
						</td>
					</tr>
				</table>

				<p>Vul hieronder de kenmerken van de binnenkant van je huis in.</p>

				<table class="formtable">
					<tr>
						<th><label>Type keuken:</label></th>
						<td>
							<select name="kitchen">
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
					<tr>
						<th><label>Hoofdverwarming:</label></th>
						<td>
							<input type="checkbox" name="stadsverwarming" value="1"  />&nbsp;<label>Stadsverwarming</label><br />
							<input type="checkbox" name="centralHeating" value="1"  />&nbsp;<label>Centrale-verwarming</label><br />
							<input type="checkbox" name="centralHeatingHighYield" value="1"  />&nbsp;<label>CV hoogrendement</label><br />
							<input type="checkbox" name="gasHeater" value="1"  />&nbsp;<label>Gaskachel</label>
						</td>
					</tr>
					<tr>
						<th>Bijverwarming:</th>
						<td>
							<input type="checkbox" name="hetelucht" value="1"  />&nbsp;<label>Hete lucht</label><br />
							<input type="checkbox" name="openhaard" value="1"  />&nbsp;<label>Open haard</label><br />
							<input type="checkbox" name="vloerverwarming" value="1"  />&nbsp;<label>Vloerverwarming</label><br />
						</td>
					</tr>
					<tr>
						<th>Sanitair:</th>
						<td>
							<input type="checkbox" name="tweedebadkamer" value="1"  />&nbsp;<label>2e badkamer</label><br />
							<input type="checkbox" name="tweedetoilet" value="1"  />&nbsp;<label>2e toilet</label><br />
							<input type="checkbox" name="bad" value="1"  />&nbsp;<label>Bad</label><br />
							<input type="checkbox" name="sauna" value="1"  />&nbsp;<label>Sauna</label>
						</td>
					</tr>
					<tr>
						<th>Isolatie:</th>
						<td>
							<input type="checkbox" name="dakisolatie" value="1" />&nbsp;<label>Dak</label><br />
							<input type="checkbox" name="dubbelglas" value="1"  />&nbsp;<label>Dubbel glas</label><br />
							<input type="checkbox" name="muurisolatie" value="1"  />&nbsp;<label>Muren</label>
						</td>
					</tr>
					<tr>
						<th>Staat van onderhoud binnen:</th>
						<td>
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

				<p>Vul hieronder de kenmerken van de buitenkant van je huis in.</p>
				<table class="formtable">
					<tr>
						<th>Tuin:</th>
						<td>
							<input type="radio" name="garden" value="1"  />&nbsp;Ja&nbsp;&nbsp;
							<input type="radio" name="garden" value="0" checked />&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<input type="checkbox" name="gardenFront" value="1"  />&nbsp;<label>Voorkant</label><br />
							<input type="checkbox" name="gardenBack" value="1"  />&nbsp;<label>Achterkant</label><br />
							<input type="checkbox" name="gardenSide" value="1"  />&nbsp;<label>Zijkant</label><br />
						</td>
					</tr>
					<tr>
						<th>Uitzicht op:</th>
						<td>
							<input type="checkbox" name="viewOrchard" value="true"  />&nbsp;<label>Boomgaard</label><br />
							<input type="checkbox" name="viewForest" value="true"  />&nbsp;<label>Bos</label><br />
							<input type="checkbox" name="viewDike" value="true"  />&nbsp;<label>Dijk</label><br />
							<input type="checkbox" name="viewTownCanal" value="true"  />&nbsp;<label>Gracht</label><br />
							<input type="checkbox" name="viewGreennesSupplies" value="true"  />&nbsp;<label>Groenvoorzieningen</label><br />
							<input type="checkbox" name="viewPort" value="true"  />&nbsp;<label>Haven</label><br />
							<input type="checkbox" name="viewMetro" value="true"  />&nbsp;<label>Metrolijn</label><br />
							<input type="checkbox" name="viewPublicGarden" value="true"  />&nbsp;<label>Park</label><br />
							<input type="checkbox" name="viewWater" value="true"  />&nbsp;<label>Water</label><br />
							<input type="checkbox" name="viewMeadow" value="true"  />&nbsp;<label>Weiland</label><br />
							<input type="checkbox" name="viewCommercial" value="true"  />&nbsp;<label>Winkels</label><br />
							<input type="checkbox" name="viewResidential" value="true"  />&nbsp;<label>Woningen</label><br />
						</td>
					</tr>
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
			</div>
			<div class="actions">
				<table class="formtable">
					<tr>
						<th><a href="#adresgegevens" class="linkbutton">vorige stap</a></th>
						<td><a href="#omschrijving" class="button">volgende stap</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	<div class="tab" id="omschrijvingtab">
		<fieldset>
			<legend>Omschrijving</legend>
			<div class="middle">
				<p>
					Je kunt hieronder een omschrijving van je huis geven (minimaal 500, maximaal 5000 tekens).
					Probeer in de omschrijving een zo goed mogelijke, aantrekkelijke omschrijving van alle
					ruimtes in je huis te geven. Probeer ook uit te leggen waarom iemand jouw huis zou moeten kopen.
				</p>
				<p>
					<em>
						<strong>Let op</strong>: Met het invoeren van de tekst verklaar ik dat ik de schrijver
						van deze tekst ben, de auteursrechten op deze tekst behoren mijn toe. Ik heb de tekst
						dan ook niet van andere rechthebbende gekopieerd.
					</em>
				</p>


				<table class="formtable">
					<tr>
						<th><label>Omschrijving:</label></th>
						<td>
							<textarea name="description" cols="50" rows="10"></textarea>
							<span id="charCounter">0</span> <b>/ 5000</b>
						</td>
					</tr>
				</table>
			</div>
			<div class="actions">
				<table class="formtable">
					<tr>
						<th><a href="#adresgegevens" class="linkbutton">vorige stap</a></th>
						<td><a href="#omschrijving" class="button">volgende stap</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	<div class="tab" id="waarderingtab">
		<fieldset>
			<legend>Waardering en prijs</legend>
			<div class="middle">
				<p>
					Hier kun je de vraagprijs van je huis opgeven. Probeer hierbij een realistische prijs te vragen. Ook kun je naar
				    Als leidraad kun je naar huizen in de omgeving kijken om je een beeld te vormen van wat je mogelijk zou kunnen vragen.
					Als je een goed beeld hebt kun je hieronder de vraagprijs van je huis invullen.
				</p>
				<table class="formtable">
					<tr>
						<th><label>Vraagprijs:</label> &euro;</th>
						<td><input type="text" name="price" id="price_text"  /></td>
					</tr>
				</table>
			</div>
			<div class="actions">
				<table class="formtable">
					<tr>
						<th><a href="#omschrijving" class="linkbutton">vorige stap</a></th>
						<td><a href="#fotos" class="button">volgende stap</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
	<div class="tab" id="fotostab">
		<fieldset>
			<legend>Foto's</legend>
			<div class="middle">
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
				<p>
					<em>
    			Let op: Door op de knop "Foto's opslaan" te klikken verklaar ik dat ik de maker
    			van dit foto materiaal ben, de auteursrechten op deze materialen behoren mij toe.
    			Ik heb de foto's dan ook niet van andere rechthebbende gekopieerd.
					</em>
				</p>

				<div id="fotoContainer">
					<div id="choose_photo_message" style="display: none">Kies een foto</div>

				</div>
			</div>
			<div class="actions">
				<table class="formtable">
					<tr>
						<th><a href="#waardering" class="linkbutton">vorige stap</a></th>
						<td><a href="#publiceren" class="button">volgende stap</a></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>

	<div class="tab" id="publicerentab">
		<fieldset>
			<legend>Publiceren</legend>
			<div class="middle">
				<p>
					Hieronder vind je de algemene voorwaarden.
				</p>
				<table class="formtable">
					<tr>
						<th><label>Algemene voorwaarden:</label></th>
						<td>
							<textarea name="algemenevoorwaarden" cols="50" rows="10">Hier komen de algemene voorwaarden in te staan</textarea>
						</td>
					</tr>
				</table>
			</div>
			<div class="actions">
				<table class="formtable">
					<tr>
						<th><a href="#omschrijving" class="linkbutton">vorige stap</a></th>
						<td><input type="submit" name="submit" value="akkoord met de voorwaarden + woning publiceren" class="button" /></td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
</form>