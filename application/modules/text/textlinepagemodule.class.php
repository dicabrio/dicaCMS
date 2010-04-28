<?php

class TextlinePageModule implements PageModuleController {
	
	const MAX_LENGTH = 255;

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var array
	 */
	private $aErrors;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page) {

		$this->oPageModule = $oMod;

		// load the data
		$this->load();
	}

	private function load() {
		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
	}
	
	/**
	 * @return string
	 */
	public function getContents() {
		if ($this->oTextContent === null) {
			return '';
		}
		
		return $this->oTextContent->getContent();
	}

	/* (non-PHPdoc)
	 * @see modules/Module#validate()
	 * TODO make UT8 compliant
	 */
	public function validate($mData) {
		return true;
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(Request $oReq) {
		return true;
	}

	public function getErrors() {
		return $this->aErrors;
	}

	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}