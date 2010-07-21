<?php

class XMLFeedException extends Exception {

}

class XMLGetter implements DomainEntity {

	/**
	 * @var DOMDocument
	 */
	private $domdoc;

	/**
	 *
	 * @var DOMDocument
	 */
	private $template;

	/**
	 *
	 * @var string
	 */
	private $xmlsource;

	/**
	 * Give a xml feed. $feedurl should be a url or file with valid xml
	 * $schemeValidationFile should point to the xsd that can validate the xml
	 *
	 * @param string $feedurl
	 * @param string $schemeValidationFile
	 */
	public function __construct($feedurl, $schemeValidationFile=null) {

		$this->xmlsource = $feedurl;
		$this->domdoc = new DOMDocument();

		$this->domdoc->load($feedurl);
		if ($schemeValidationFile != null) {
			if (!$this->domdoc->schemaValidate($schemeValidationFile)) {
				throw new XMLFeedException('xml-notvalid', 300);
			}
		}
		
	}

	public function setSource(XMLFeed $xml) {

		$this->domdoc = new DOMDocument();
		$this->domdoc->loadXML($xml->getXML());
	}

	public function addTemplate(View $view) {

		$this->template = new DOMDocument();
		$this->template->loadXML($view->getContents());

	}

	public function getContents() {

		$xslt = new XSLTProcessor();
		$xslt->importStylesheet($this->template);
		return $xslt->transformToXml($this->domdoc);

	}

	/**
	 * return the url
	 * @return string
	 */
	public function getSourceLocation() {

		return $this->xmlsource;

	}

	public function equals($object) {

		if (empty($object)) {
			return false;
		}

		if (!is_a($object, get_class($this))) {
			return false;
		}

		if ($object->xmlsource !== $this->xmlsource) {
			return false;
		}

		return true;

	}

	/**
	 * @return string
	 */
	public function  __toString() {

		return $this->domdoc->saveXML();

	}

}

