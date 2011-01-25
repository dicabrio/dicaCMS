<?php

class DashboardCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

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


	}

	private function defineForm() {

		// Thnx page field
//		$select = new Select('bedanktpagina');
//		$select->addOption(0, Lang::get('general.choose'));
//		foreach ($this->pages as $page) {
//			$select->addOption($page->getID(), $page->getName());
//		}
//		$select->setValue($this->page);
//		$this->form->addFormElement($select->getName(), $select);

		// define the mapping

		// Email field
//		$this->emailField = new Input('text', $this->oPageModule->getIdentifier(), $this->email);
//		$this->emailField->addAttribute('maxlength', self::MAX_LENGTH);
//		$this->form->addFormElement($this->emailField->getName(), $this->emailField);

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

		$oView = new View(Conf::get('general.dir.templates').'/hvwdashboard/hvwdashboard.php');
		$oView->form = $this->form;
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		return $oView;

	}

	/**
	 * @return boolean
	 */
	public function handleData() {

//		$sModIdentifier = $this->oPageModule->getIdentifier();
//		$email = $this->mapper->getModel($sModIdentifier);
//		$thnxpage = $this->mapper->getModel("bedanktpagina");
//
//		$this->oTextContent->setContent($email.','.$thnxpage->getID());
//		$this->oTextContent->setPageModule($this->oPageModule);
//		$this->oTextContent->save();

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