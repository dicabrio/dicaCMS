<?php


class CheckboxInput extends Input {


	public function __construct($name) {
		parent::__construct('checkbox', $name);
	}

	public function __toString() {

		if ($this->getValue() == 1) {
			$checked = 'checked="checked"';
		}

		return sprintf('<input type="hidden" name="%s" value="0" /><input type="checkbox" name="%s" value="1" %s />',
			$this->getName(),
			$this->getName(),
			$checked);
	}
}