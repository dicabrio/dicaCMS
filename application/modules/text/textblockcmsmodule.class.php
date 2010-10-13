<?php

class TextblockCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var Form
	 */
	private $form;

	/**
	 *
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 *
	 * @var TextArea
	 */
	private $textArea;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->oPageModule = $oMod;
		$this->form = $form;

		// load the data
		$this->load();
	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		
		$this->textArea = new TextArea($this->oPageModule->getIdentifier(), $this->oTextContent->getContent());
		$this->form->addFormElement($this->textArea->getName(), $this->textArea);

	}

	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$mapper->addFormElementToDomainEntityMapping($this->textArea->getName(), 'DomainText');

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

//		if ($this->oCmsController !== null) {
//
//			$this->oCmsController->getBaseView()->addStyle(Conf::get('general.url.js').'/yui/assets/skins/sam/skin.css');
//			$this->oCmsController->getBaseView()->addScript('yui/yahoo-dom-event/yahoo-dom-event.js');
//			$this->oCmsController->getBaseView()->addScript('yui/element/element-min.js');
//			$this->oCmsController->getBaseView()->addScript('yui/container/container_core-min.js');
//			$this->oCmsController->getBaseView()->addScript('yui/editor/simpleeditor-min.js');
//			$this->oCmsController->getBaseView()->addScript('wysiwyg-startup.js');
//		}


		$oView = new View('text/textblock.php');
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		$oView->form = $this->form;
		return $oView;

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
	public function handleData() {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$text = $this->mapper->getModel($sModIdentifier);

		if ($this->oTextContent === null) {
			$this->oTextContent = new PageText();
		}

		$this->oTextContent->setContent((string)$text);
		$this->oTextContent->setPageModule($this->oPageModule);
		$this->oTextContent->save();

	}

	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}