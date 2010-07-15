<?php

class ContactformCmsModule implements CmsModuleController {

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
	private $pages;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var int
	 */
	private $page;

	/**
	 * @var Form
	 */
	private $form;

	/**
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 *
	 * @param Page $oPage
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $controller
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, FormMapper $mapper, CmsController $controller = null) {

		$this->oPageModule = $oMod;
		$this->form = $form;
		$this->mapper = $mapper;
		$this->oCmsController = $controller;

		// load the data
		$this->load();
		$this->defineForm();

	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);

		$values = explode(',', $this->oTextContent->getContent());

		if (!isset($values[1])) {
			$this->email = $values[0];
			$this->page = 0;
		} else {
			$this->email = $values[0];
			$this->page = $values[1];
		}

		$this->pages = Page::findActive();

	}

	private function defineForm() {

		// Thnx page field
		$select = new Select('bedanktpagina');
		$select->addOption(0, Lang::get('general.choose'));
		foreach ($this->pages as $page) {
			$select->addOption($page->getID(), $page->getName());
		}
		$select->setValue($this->page);
		$this->form->addFormElement($select->getName(), $select);

		// define the mapping
		$this->mapper->addFormElementToDomainEntityMapping('bedanktpagina', "Page");

		// Email field
		$emailField = new Input('text', $this->oPageModule->getIdentifier(), $this->email);
		$emailField->addAttribute('maxlength', self::MAX_LENGTH);
		$this->form->addFormElement($emailField->getName(), $emailField);

		// define the mapping
		$this->mapper->addFormElementToDomainEntityMapping($emailField->getName(), "Email");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$oView = new View('contact/contactconfig.php');
		$oView->form = $this->form;
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		return $oView;

	}

	/**
	 * @return boolean
	 */
	public function handleData() {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$email = $this->mapper->getModel($sModIdentifier);
		$thnxpage = $this->mapper->getModel("bedanktpagina");

		$this->oTextContent->setContent($email.','.$thnxpage->getID());
		$this->oTextContent->setPageModule($this->oPageModule);
		$this->oTextContent->save();

		return true;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}