<?php
/**
 * Description of textnodeclass
 *
 * @author robertcabri
 */
class Paragraph extends DomainText {

	/**
	 *
	 * @param string $sValue
	 */
	public function __construct($sValue=null) {
		parent::__construct($sValue);
	}

	/**
	 * 
	 */
	public function cleanUpHTML() {
		// check if it has paragraph wrapt around it

		$text = trim($this->getValue());
		if (!preg_match('/^<p(.+)\/p>$/', $text)) {
			$this->setValue('<p>'.$text.'</p>');
		}
	}
}
