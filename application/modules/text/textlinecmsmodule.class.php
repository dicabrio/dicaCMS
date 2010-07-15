<?php

class TextlineCmsModule implements CmsModuleController {
	
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
	public function __construct(PageModule $oMod, Form $form, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;

		// load the data
		$this->load();
	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {
		$oView = new View('text/textline.php');
		$oView->sMaxLength = self::MAX_LENGTH;
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		if ($this->oTextContent === null) {
			$oView->sContent = '';
		} else {
			$oView->sContent = $this->oTextContent->getContent();
		}
		return $oView;
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

	/**
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->aErrors;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}