<?php

class CheckboxInput extends Input {

	/**
	 * @var boolean
	 */
	private $checked = false;
	
	/**
	 *
	 * @var boolean
	 */
	private $arrayType = false;

	/**
	 * 
	 * @param string $name
	 * @param mixed $defaultValue
	 */
	public function __construct($name, $defaultValue = 1) {

		if (preg_match('/\[.*\]/', $name)) {
			$this->arrayType = true;
		}

		parent::__construct('checkbox', $name, $defaultValue);
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		if ($this->arrayType) {
			$id = preg_replace('/\[.*\]/', '_', parent::getIdentifier());
			return $id . parent::getValue();
		}

		return parent::getIdentifier();
	}

	/**
	 * 
	 * @return string
	 */
	public function getName() {
		return preg_replace('/\[.*\]/', '', parent::getName());
	}

	/**
	 * 
	 * @param string $value
	 */
	public function setValue($value) {
		$this->check($value);
	}

	private function check($value) {
		$originalValue = parent::getValue();
		if (is_array($value) && in_array($originalValue, $value)) {
			$this->checked = true;
		} else if ($originalValue == $value) {
			$this->checked = true;
		} else {
			$this->checked = false;
		}
	}

	public function getValue() {
		if ($this->checked == true) {
			return parent::getValue();
		}

		return null;
	}

	/**
	 * 
	 * @return string
	 */
	public function __toString() {

		$checked = "";
		if ($this->checked) {
			$checked = 'checked="checked"';
		}

		if ($this->arrayType === false) {
			return (string) sprintf('<input type="hidden" name="%s" value="0" /><input type="checkbox" name="%s" value="1" %s />', $this->getName(), $this->getName(), $checked);
		}


		return (string) sprintf('<input type="checkbox" name="%s" value="%s" %s />', $this->getName() . '[]', parent::getValue(), $checked);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isChecked() {

		return $this->checked;
	}

	/**
	 *
	 * @return Boolean
	 */
	public function  isSelected() {
		return $this->checked;
	}

}