<?php
/**
 * Description of textnodeclass
 *
 * @author robertcabri
 */
class RequiredNumber extends Number {

	/**
	 *
	 * @param string $sValue
	 * @param int $iMinLength
	 * @param int $iMaxLength
	 */
	public function __construct($sValue=null) {

		if (empty($sValue)) {
			throw new InvalidArgumentException('no-value-given');
		}

		if (!is_numeric($sValue)) {
			throw new InvalidArgumentException('value-is-not-a-number');
		}
		
		parent::__construct($sValue, null, 255);

	}
}
