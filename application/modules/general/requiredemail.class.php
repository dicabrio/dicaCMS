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
class RequiredEmail extends Email {

	/**
	 * minimum length should be 3 and max lenght should be 30
	 * @param string $sValue
	 */
	public function __construct($value=null) {

		if (empty($value)) {
			throw new InvalidArgumentException('not-filled', 100);
		}

		parent::__construct($value);
	}

}
