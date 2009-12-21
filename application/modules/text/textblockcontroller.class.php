<?php

class TextblockController implements ModuleController {

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
	 * @var CmsController
	 */
	private $oCmsController;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;

		$this->oCmsController = $oCmsController;

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

		if ($this->oCmsController !== null) {

			$this->oCmsController->getBaseView()->addStyle(Conf::get('general.url.js').'/yui/assets/skins/sam/skin.css');
			$this->oCmsController->getBaseView()->addScript('yui/yahoo-dom-event/yahoo-dom-event.js');
			$this->oCmsController->getBaseView()->addScript('yui/element/element-min.js');
			$this->oCmsController->getBaseView()->addScript('yui/container/container_core-min.js');
			$this->oCmsController->getBaseView()->addScript('yui/editor/simpleeditor-min.js');
			$this->oCmsController->getBaseView()->addScript('wysiwyg-startup.js');
		}


		$oView = new View('text/textblock.php');
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		if ($this->oTextContent === null) {
			$oView->sContent = '';
		} else {
			$oView->sContent = $this->oTextContent->getContent();
		}
		return $oView;
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