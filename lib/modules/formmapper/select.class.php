<?php

/**
 * A basic input field
 */
class Select implements FormElement {

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var string
	 */
	private $style;

	/**
	 * @var array
	 */
	private $options = array();

	/**
	 * @var array
	 */
	private $attributes = array();

	/**
	 * @param string $name
	 */
	public function __construct($name) {
		$this->name = $name;
	}

	/**
	 * @param string $sValue
	 */
	public function setValue($sValue) {
		$this->value = $sValue;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function getName() {

		return $this->formatName($this->name);
	}

	/**
	 * formats this "test123[123]" to "test123_123"
	 *
	 *
	 * @param string $name
	 * @return string
	 */
	private function formatName($name) {

		return $name;
	}

	/**
	 *
	 * @return s
	 */
	public function getIdentifier() {

		return $this->name;
	}

	/**
	 * @return string
	 */
	public function __toString() {

		$name = $this->name;
		$multiple = false;
		if (isset($this->attributes['multiple'])) {
			$name = $name . '[]';
			$multiple = true;
		}

		$options = "";
		foreach ($this->options as $value => $label) {

			$selected = "";

			if ($multiple === true && is_array($this->value) && in_array($value, $this->value)) {
				$selected = 'selected="selected"';
			} else if ($value == $this->value) {
				$selected = 'selected="selected"';
			}

			$options .= sprintf('<option value="%s" %s>%s</option>', $value, $selected, $label);
		}

		$attributes = "";
		foreach ($this->attributes as $attName => $attValue) {
			$attributes .= sprintf(' %s="%s"', $attName, $attValue);
		}

		return sprintf('<select name="%s" %s %s>%s</select>', $name, $attributes, $this->style, $options);
	}

	public function addOption($value, $label) {
		$this->options[$value] = $label;
		return $this;
	}

	/**
	 * @param string $attribute
	 * @param string $value
	 */
	public function addAttribute($attribute, $value) {
		$this->attributes[$attribute] = $value;
		return $this;
	}

	/**
	 * @return void
	 */
	public function notMapped() {
		$this->style = ' style="border: 1px solid red;"';
	}

	public function isSelected() {
		return true;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return 'select';
	}

	/**
	 * Declare the mapping for this form element. If no mapping is define it will return the mapping
	 * defined for this element
	 *
	 * @param string $sModelName
	 */
	public function mapTo($sModelName=null) {

		if ($sModelName === null) {
			return $this->mapping;
		}
		$this->mapping = $sModelName;
	}

}