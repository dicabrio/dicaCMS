<?php

class RegisterformCmsModule implements CmsModuleController {

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
	public function __construct(PageModule $oMod, Form $form) {

		$this->oPageModule = $oMod;
		$this->form = $form;

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

		// Email field
		$this->emailField = new Input('text', $this->oPageModule->getIdentifier(), $this->email);
		$this->emailField->addAttribute('maxlength', self::MAX_LENGTH);
		$this->form->addFormElement($this->emailField->getName(), $this->emailField);

		// define the mapping

	}

	public function addFormMapping(FormMapper $mapper) {
		$this->mapper = $mapper;
//		$this->mapper->addFormElementToDomainEntityMapping('bedanktpagina', "Page");
//		$this->mapper->addFormElementToDomainEntityMapping($this->emailField->getName(), "Email");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {


		return '';
		$oView = new View(Conf::get('general.dir.templates').'/contact/contactconfig.php');
		$oView->form = $this->form;
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		return $oView;

	}

	/**
	 * @return boolean
	 */
	public function handleData() {

		return true;

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