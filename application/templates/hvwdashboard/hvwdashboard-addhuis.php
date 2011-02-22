<?php echo $form->begin(); ?>
	<ul id="tabmenu">
		<li class="active"><a href="#adresgegevens" class="adresgegevens">Adres</a></li>
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

				<div id="map" style="width: 300px; height: 170px; float: right; border: 1px solid #ccc;"></div>

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
	<div class="tab" id="kenmerkentab">
		<fieldset>
			<legend>Kenmerken</legend>

			<div class="middle">
				<p>Vul hieronder de algemene kenmerken van je huis in.</p>

				<table class="formtable">
					<tr>
						<th><label>Woningtype:</label></th>
						<td>
							<?php echo $form->getFormElement('woningtype'); ?>
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
				</table>
				<p>Als je de inhoud van je huis niet weet, neem dan het woonoppervlak en vermenigvuldig dit met 2.5</p>
				<table class="formtable">
					<tr>
						<th>Aantal kamers:</th>
						<td>
							<?php echo $form->getFormElement('aantalkamers'); ?>
						</td>
					</tr>
					<tr>
						<th>Aantal dakkapellen:</th>
						<td>
							<?php echo $form->getFormElement('aantaldakkapellen'); ?>
						</td>
					</tr>
					<tr>
						<th>Garage:</th>
						<td>
							<?php echo $form->getFormElement('garage_1'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('garage_0'); ?>&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Zwembad:</th>
						<td>
							<?php echo $form->getFormElement('zwembad_1'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('zwembad_0'); ?>&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Balkon:</th>
						<td>
							<?php echo $form->getFormElement('balkon_1'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('balkon_0'); ?>&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>Lift:</th>
						<td>
							<?php echo $form->getFormElement('lift_1'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('lift_0'); ?>&nbsp;Nee
						</td>
					</tr>
				</table>

				<p>Vul hieronder de kenmerken van de binnenkant van je huis in.</p>

				<table class="formtable">
					<tr>
						<th><label>Type keuken:</label></th>
						<td>
							<?php echo $form->getFormElement('keukentype'); ?>
						</td>
					</tr>
					<tr>
						<th><label>Hoofdverwarming:</label></th>
						<td>
							<?php echo $form->getFormElement('stadsverwarming'); ?>&nbsp;<label>Stadsverwarming</label><br />
							<?php echo $form->getFormElement('centraleverwarming'); ?>&nbsp;<label>Centrale-verwarming</label><br />
							<?php echo $form->getFormElement('cvhoogrendement'); ?>&nbsp;<label>CV hoogrendement</label><br />
							<?php echo $form->getFormElement('gaskachel'); ?>&nbsp;<label>Gaskachel</label>
						</td>
					</tr>
					<tr>
						<th>Bijverwarming:</th>
						<td>
							<?php echo $form->getFormElement('hetelucht'); ?>&nbsp;<label>Hete lucht</label><br />
							<?php echo $form->getFormElement('openhaard'); ?>&nbsp;<label>Open haard</label><br />
							<?php echo $form->getFormElement('vloerverwarming'); ?>&nbsp;<label>Vloerverwarming</label><br />
						</td>
					</tr>
					<tr>
						<th>Sanitair:</th>
						<td>
							<?php echo $form->getFormElement('tweedebadkamer'); ?>&nbsp;<label>2e badkamer</label><br />
							<?php echo $form->getFormElement('tweedetoilet'); ?>&nbsp;<label>2e toilet</label><br />
							<?php echo $form->getFormElement('bad'); ?>&nbsp;<label>Bad</label><br />
							<?php echo $form->getFormElement('sauna'); ?>&nbsp;<label>Sauna</label>
						</td>
					</tr>
					<tr>
						<th>Isolatie:</th>
						<td>
							<?php echo $form->getFormElement('dakisolatie'); ?>&nbsp;<label>Dak</label><br />
							<?php echo $form->getFormElement('dubbelglas'); ?>&nbsp;<label>Dubbel glas</label><br />
							<?php echo $form->getFormElement('muurisolatie'); ?>&nbsp;<label>Muren</label>
						</td>
					</tr>
					<tr>
						<th><label for="onderhoudsstaatbinnen">Staat van onderhoud binnen:</label></th>
						<td>
							<?php echo $form->getFormElement('onderhoudsstaatbinnen'); ?>
						</td>
					</tr>
				</table>
				<p>Vul hieronder de kenmerken van de buitenkant van je huis in.</p>
				<table class="formtable">
					<tr>
						<th>Tuin:</th>
						<td>
							<?php echo $form->getFormElement('tuin_0'); ?>&nbsp;Ja&nbsp;&nbsp;
							<?php echo $form->getFormElement('tuin_1')->addAttribute('checked', 'checked'); ?>&nbsp;Nee
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<?php echo $form->getFormElement('voorkanttuin'); ?>&nbsp;<label>Voorkant</label><br />
							<?php echo $form->getFormElement('achterkanttuin'); ?>&nbsp;<label>Achterkant</label><br />
							<?php echo $form->getFormElement('zijkanttuin'); ?>&nbsp;<label>zijkant</label><br />
						</td>
					</tr>
					<tr>
						<th>Uitzicht op:</th>
						<td>
							<?php echo $form->getFormElement('boomgaard'); ?>&nbsp;<label>Boomgaard</label><br />
							<?php echo $form->getFormElement('bos'); ?>&nbsp;<label>Bos</label><br />
							<?php echo $form->getFormElement('dijk'); ?>&nbsp;<label>Dijk</label><br />
							<?php echo $form->getFormElement('gracht'); ?>&nbsp;<label>Gracht</label><br />
							<?php echo $form->getFormElement('groenvoorzieningen'); ?>&nbsp;<label>Groenvoorzieningen</label><br />
							<?php echo $form->getFormElement('haven'); ?>&nbsp;<label>Haven</label><br />
							<?php echo $form->getFormElement('metrolijn'); ?>&nbsp;<label>Metrolijn</label><br />
							<?php echo $form->getFormElement('park'); ?>&nbsp;<label>Park</label><br />
							<?php echo $form->getFormElement('water'); ?>&nbsp;<label>Water</label><br />
							<?php echo $form->getFormElement('weiland'); ?>&nbsp;<label>Weiland</label><br />
							<?php echo $form->getFormElement('winkels'); ?>&nbsp;<label>Winkels</label><br />
							<?php echo $form->getFormElement('woningen'); ?>&nbsp;<label>Woningen</label><br />
						</td>
					</tr>
					<tr>
						<td><label for="onderhoudsstaatbuiten">Staat van onderhoud buiten:</label></td>
						<td>
							<?php echo $form->getFormElement('onderhoudsstaatbuiten'); ?>
						</td>
					</tr>
					<tr>
						<td><label for="onderhoudsstaatschilderwerk">Staat van onderhoud schilderwerk:</label></td>
						<td>
							<?php echo $form->getFormElement('onderhoudsstaatschilderwerk'); ?>
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
							<?php echo $form->getFormElement('omschrijving')->addAttribute('cols', 50)->addAttribute('rows', 10); ?>
							<span id="omschrijvingteller">0</span> <b>/ 5000</b>
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
						<th><label for="vraagprijs">Vraagprijs:</label> &euro;</th>
						<td><?php echo $form->getFormElement('vraagprijs'); ?></td>
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
						<td>
							<input type="submit" name="submit" value="preview" class="button" />
							<input type="submit" name="submit" value="akkoord met de voorwaarden + woning publiceren" class="button" />
						</td>
					</tr>
				</table>
				<div class="clear"></div>
			</div>
		</fieldset>
	</div>
<?php echo $form->end(); ?>