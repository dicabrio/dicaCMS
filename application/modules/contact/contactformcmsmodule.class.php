<?php

class ContactformCmsModule implements CmsModuleController {

	const MAX_LENGTH = 255;

	/**
	 * @var PageModule
	 */
	private $pageModule;

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
	 * @var string
	 */
	private $label;

	/**
	 *
	 * @param Page $oPage
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $controller
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->pageModule = $oMod;
		$this->form = $form;

		// load the data
		$this->load();
		$this->defineForm();

	}

	private function load() {
		
		
		$this->label = 'Contact Form';
		$this->getParam('label');

		$this->oTextContent = PageText::getByPageModule($this->pageModule);

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
		$this->form->addFormElement($select);

		// define the mapping

		// Email field
		$this->emailField = new Input('text', $this->pageModule->getIdentifier(), $this->email);
		$this->emailField->addAttribute('maxlength', self::MAX_LENGTH);
		$this->form->addFormElement($this->emailField);

		// define the mapping

	}

	public function addFormMapping(FormMapper $mapper) {
		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping('bedanktpagina', "Page");
		$this->mapper->addFormElementToDomainEntityMapping($this->emailField->getName(), "Email");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/contact/contactconfig.php');
		$view->assign('form', $this->form);
		$view->assign('identifier', $this->pageModule->getIdentifier());
		$view->assign('label', $this->label);
		return $view;

	}

	/**
	 * @return boolean
	 */
	public function handleData() {

		$sModIdentifier = $this->pageModule->getIdentifier();
		$email = $this->mapper->getModel($sModIdentifier);
		$thnxpage = $this->mapper->getModel("bedanktpagina");

		$this->oTextContent->setContent($email.','.$thnxpage->getID());
		$this->oTextContent->setPageModule($this->pageModule);
		$this->oTextContent->save();

		return true;
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