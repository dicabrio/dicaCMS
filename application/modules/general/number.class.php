<?php
/**
 * Description of textnodeclass
 *
 * @author robertcabri
 */
class Number extends DomainText {

	/**
	 *
	 * @param string $sValue
	 * @param int $iMinLength
	 * @param int $iMaxLength
	 */
	public function __construct($sValue=null) {

		if (!empty($sValue) && !is_numeric($sValue)) {
			throw new Exception('Given value is not a number');
		}
		
		parent::__construct($sValue, null, 255);

	}
}
