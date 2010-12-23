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

		$oView = new View(Conf::get('general.dir.templates').'/text/textblock.php');
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		$oView->form = $this->form;
		return $oView;

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