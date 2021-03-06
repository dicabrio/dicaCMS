<?php

/**
 * A basic radio field
 */
class Radio extends FormElementImpl {

	/**
	 * @param string $sType
	 * @param string $name
	 */
	public function __construct($name, $value = null, $checked = false) {

		parent::__construct('input', $name, $value);
		$this->addAttribute('type', 'radio');

		if ($checked == true) {
			$this->addAttribute('checked', 'checked');
		}
	}

	/**
	 * Because there can be multiple radiobuttons. The identifier is build out of the
	 * name and the value
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return parent::getIdentifier() . '_' . parent::getValue();
	}

	/**
	 *
	 * @param string $val
	 */
	public function setValue($val) {
		if ($val == $this->getValue()) {
			$this->addAttribute('checked', 'checked');
		} else {
			$this->removeAttribute('checked');
		}
	}

	/**
	 * @return boolean
	 */
	public function isSelected() {

		return ('checked' == $this->getAttribute('checked'));

	}

}