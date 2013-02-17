<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of textnodeclass
 *
 * @author robertcabri
 */
class Email extends DomainText {

	const EMAIL_PATTERN = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
//	const EMAIL_PATTERN = '/\b[A-Z0-9._%\-]+@[A-Z0-9\.\-]+\.[A-Z]{2,4}\b/';
//	const EMAIL_PATTERN = '/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD';
	/**
	 * minimum length should be 3 and max lenght should be 30
	 * @param string $sValue
	 */
	public function __construct($value=null) {

		if (!empty($value)) {
			if (!preg_match(self::EMAIL_PATTERN, $value)) {
				throw new InvalidArgumentException('not-well-formed', 100);
			}
		}
		parent::__construct($value);
	}

}
