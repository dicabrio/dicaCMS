<?php
/**
 * A basic input field
 */
class Input implements FormElement {

	/**
	 * @var string
	 */
	private $sType;

	/**
	 * @var string
	 */
	private $sName;

	/**
	 * @var string
	 */
	private $sValue;

	/**
	 * @var string
	 */
	private $sStyle;

	/**
	 * @var array
	 */
	private $attributes = array();

	/**
	 * @param string $sType
	 * @param string $sName
	 */
	public function __construct($sType, $sName, $value = null) {
		$this->sName = $sName;
		$this->sType = $sType;
		$this->sValue = $value;
	}

	/**
	 * @param string $sValue
	 */
	public function setValue($sValue) {
		$this->sValue = $sValue;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->sValue;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->sName;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		try {
		$sAttributes = "";
		foreach ($this->attributes as $name => $value) {
			$sAttributes .= sprintf(' %s="%s"', $name, $value);
		}

		return '<input type="'.$this->sType.'" name="'.$this->sName.'" value="'.$this->sValue.'" '.$this->sStyle.' '.$sAttributes.' />';
		} catch (Exception $e) {
			return (string)$e->getMessage();
		}
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
		$this->sStyle = ' style="border: 1px solid red;"';
		return $this;
	}

	public function isSelected() {
		return true;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->sType;
	}
}