<?php

class AddHouseForm extends Form {

	protected function defineFormElements() {

		$propertyTypes = Conf::get('houseproperties.propertytypes');
		$propertyTypeSelect = new Select('woningtype');
		$propertyTypeSelect->addOption('0', 'Maak een keuze');
		foreach ($propertyTypes as $value => $label) {
			$propertyTypeSelect->addOption($value, $label);
		}

		$onderhoudBuiten = new Select('onderhoudsstaatbuiten');
		$onderhoudBinnen = new Select('onderhoudsstaatbinnen');
		$onderhoudSchilderwerk = new Select('onderhoudsstaatschilderwerk');

		$onderhoudBuiten->addOption('0', 'Maak een keuze');
		$onderhoudBinnen->addOption('0', 'Maak een keuze');
		$onderhoudSchilderwerk->addOption('0', 'Maak een keuze');

		$onderhoudValues = Conf::get('houseproperties.maintenance');
		foreach ($onderhoudValues as $value => $label) {
			$onderhoudBuiten->addOption($value, $label);
			$onderhoudBinnen->addOption($value, $label);
			$onderhoudSchilderwerk->addOption($value, $label);
		}

//		keukentype
		$keukentype = new Select('keukentype');
		$keukentype->addOption('0', 'Maak een keuze');
		$keukentypeOpties = Conf::get('houseproperties.keukentype');
		foreach ($keukentypeOpties as $value => $label) {
			$keukentype->addOption($value, $label);
		}

		$formElements = array(
			new Input('text', 'postcode'),
			new Input('text', 'huisnummer'),
			new Input('text', 'toevoeging'),
			$propertyTypeSelect,
			new Input('text', 'bouwjaar'),
			new Input('text', 'perceeloppervlak'),
			new Input('text', 'woonoppervlak'),
			new Input('text', 'inhoud'),
			new Radio('gestoffeerd', '1'),
			new Radio('gestoffeerd', '0', true),
			new Radio('gemeubileerd', '1'),
			new Radio('gemeubileerd', '0', true),
			new Input('text', 'aantalkamers'),
			new Input('text', 'aantaldakkapellen'),
			new Radio('garage', '1'),
			new Radio('garage', '0', true),
			new Radio('zwembad', '1'),
			new Radio('zwembad', '0', true),
			new Radio('balkon', '1'),
			new Radio('balkon', '0', true),
			new Radio('lift', '1'),
			new Radio('lift', '0', true),
			$keukentype,
			// hoofdverwarming
			new CheckboxInput('stadsverwarming'),
			new CheckboxInput('centraleverwarming'),
			new CheckboxInput('cvhoogrendement'),
			new CheckboxInput('gaskachel'),
			// bijverwarming
			new CheckboxInput('hetelucht'),
			new CheckboxInput('openhaard'),
			new CheckboxInput('vloerverwarming'),
			// sanitair
			new CheckboxInput('tweedebadkamer'),
			new CheckboxInput('tweedetoilet'),
			new CheckboxInput('bad'),
			new CheckboxInput('sauna'),
			// isolatie
			new CheckboxInput('dakisolatie'),
			new CheckboxInput('dubbelglas'),
			new CheckboxInput('muurisolatie'),
			$onderhoudBinnen,
			new Radio('tuin', '1'),
			new Radio('tuin', '0', true),
			new CheckboxInput('voorkanttuin'),
			new CheckboxInput('achterkanttuin'),
			new CheckboxInput('zijkanttuin'),
			// uitzicht
			new CheckboxInput('boomgaard'),
			new CheckboxInput('bos'),
			new CheckboxInput('dijk'),
			new CheckboxInput('gracht'),
			new CheckboxInput('groenvoorzieningen'),
			new CheckboxInput('haven'),
			new CheckboxInput('metrolijn'),
			new CheckboxInput('park'),
			new CheckboxInput('water'),
			new CheckboxInput('weiland'),
			new CheckboxInput('winkels'),
			new CheckboxInput('woningen'),
			$onderhoudBuiten,
			$onderhoudSchilderwerk,
			// omschrijving
			new TextArea('omschrijving'),
			new Input('text', 'vraagprijs'),
		);

		foreach ($formElements as $formElement) {
			$this->addFormElement($formElement);
		}
	}

}