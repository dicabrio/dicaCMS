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
		if (is_string($mData) && strlen($mData) <= self::MAX_LENGTH) {
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(Request $oReq) {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		if ($this->validate($oReq->post($sModIdentifier))) {

			if ($this->oTextContent === null) {
				$this->oTextContent = new PageText();
			}

			$this->oTextContent->setContent($oReq->post($sModIdentifier));
			$this->oTextContent->setPageModule($this->oPageModule);
			$this->oTextContent->save();
				
			return true;
		}

		return false;
	}

	public function getErrors() {
		return $this->aErrors;
	}

	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}