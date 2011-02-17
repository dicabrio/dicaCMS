<?php


class AddHouseForm extends Form {


	protected function defineFormElements() {


		$formElements = array(
			new Input('text', 'postcode'),
			new Input('text', 'huisnummer'),
			new Input('text', 'toevoeging'),
			new Select('woningtype'),
			new Input('text', 'bouwjaar'),
			new Input('text', 'perceeloppervlak'),
			new Input('text', 'woonoppervlak'),
			new Input('text', 'inhoud'),
			new Radio('gestoffeerd', '0'),
			new Radio('gestoffeerd', '1'),
			new Radio('gemeubileerd', '0'),
			new Radio('gemeubileerd', '1'),
			new Input('text', 'aantalkamers'),
			new Input('text', 'aantaldakkapellen'),
			new Radio('garage', '0'),
			new Radio('garage', '1'),
			new Radio('zwembad', '0'),
			new Radio('zwembad', '1'),
			new Radio('balkon', '0'),
			new Radio('balkon', '1'),
			new Radio('lift', '0'),
			new Radio('lift', '1'),
			new Select('keukentype'),
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
			new CheckboxInput('dak'),
			new CheckboxInput('dubbelglas'),
			new CheckboxInput('muren'),

			new Select('onderhoudsstaatbinnen'),

			new Radio('tuin', '0'),
			new Radio('tuin', '1'),
			new CheckboxInput('voorkanttuin'),
			new CheckboxInput('achterkanttuin'),
			new CheckboxInput('zijkanttuin'),
		);

		foreach ($formElements as $formElement) {
			$this->addFormElement($formElement);
		}
	}


}