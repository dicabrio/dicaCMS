<?php
/**
 * Description of textnodeclass
 *
 * @author robertcabri
 */
class DomainText implements DomainEntity {

/**
 * @var string
 */
	private $sValue;

	/**
	 *
	 * @param string $sValue
	 * @param int $iMinLength
	 * @param int $iMaxLength
	 */
	public function __construct($sValue=null, $iMinLength = null, $iMaxLength=null) {
		if ($iMinLength !== null && mb_strlen($sValue, 'UTF-8') < $iMinLength) {
			throw new InvalidArgumentException('value-too-short', 10);
		}

		if ($iMaxLength !== null && mb_strlen($sValue, 'UTF-8') > $iMaxLength) {
			throw new InvalidArgumentException('value-too-long', 20);
		}

		$this->sValue = $sValue;
	}

	/**
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->sValue;
	}

	/**
	 *
	 * @param string $value
	 */
	protected function setValue($value) {
		$this->sValue = $value;
	}

	/**
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->sValue."";
	}

	/**
	 *
	 * @param mixed $oObject
	 * @return bool
	 */
	public function equals($oObject) {
		if (!is_object($oObject)) {
			return false;
		}

		if (get_class($this) !== get_class($oObject)) {
			return false;
		}

		return ($oObject->sValue === $this->sValue);

	}
}
