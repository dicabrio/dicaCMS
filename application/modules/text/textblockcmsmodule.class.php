<?php

class TextblockCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var PageText
	 */
	private $textContent;

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
	 *
	 * @var Bool
	 */
	private $htmlEditor;
	
	/**
	 *
	 * @var string
	 */
	private $label;
	
	/**
	 *
	 * @var int
	 */
	private $maxlength;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->pageModule = $oMod;
		$this->form = $form;
		$this->htmlEditor = false;
		$this->label = 'Text block : '.$oMod->getIdentifier();
		$this->maxlength = 0;

		// load the data
		$this->load();
	}

	/**
	 * Load the data for this module
	 */
	private function load() {

		$this->textContent = PageText::getByPageModule($this->pageModule);
		
		$this->textArea = new TextArea($this->pageModule->getIdentifier(), $this->textContent->getContent());
		$this->form->addFormElement($this->textArea);
		
		$this->getParam('label');
		$this->getParam('maxlength');

	}

	/**
	 * add form mapping
	 * 
	 * @param FormMapper $mapper
	 */
	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$mapper->addFormElementToDomainEntityMapping($this->textArea->getName(), 'Paragraph');

	}

	/**
	 * 
	 */
	protected function enableHtmlEditor() {
		$this->htmlEditor = true;
	}

	/**
	 *
	 * @return View 
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/text/textblock.php');
		$view->assign('sIdentifier', $this->pageModule->getIdentifier());
		$view->assign('form', $this->form);
		$view->assign('htmlEditor', $this->htmlEditor);
		$view->assign('label', $this->label);
		
		return $view;

	}

	/**
	 *
	 */
	public function handleData() {

		$modIdentifier = $this->pageModule->getIdentifier();
		$text = $this->mapper->getModel($modIdentifier);

		if ($this->htmlEditor === true) {
			$text->cleanUpHTML();
		}

		if ($this->textContent === null) {
			$this->textContent = new PageText();
		}

		$this->textContent->setContent((string)$text);
		$this->textContent->setPageModule($this->pageModule);
		$this->textContent->save();

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}
	
	/**
	 *
	 * @param string $name 
	 */
	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}
}