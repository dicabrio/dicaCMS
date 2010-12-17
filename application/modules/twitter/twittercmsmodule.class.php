<?php

class TwitterCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var TemplateFile
	 */
	private $templateFile;

	/**
	 * @var Form
	 */
	private $form;

	/**
	 *
	 * @var array
	 */
	private $options;

	/**
	 * @var Select
	 */
	private $selectElement;

	/**
	 *
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

		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);
		if ($this->templateFile == null) {
			$this->templateFile = new TemplateFile();
		}

		$module = current(Module::getForTemplates('twitter'));
		$this->options = TemplateFile::findByModule($module);

	}

	private function defineForm() {

		$identifier = $this->oPageModule->getIdentifier();

		$this->twitterAccountName = new Input('text', $identifier.'_account', '');
		$this->twitterAmount = new Input('text', $identifier.'_amount', '');

		$this->selectElement = new Select($identifier);
		$this->selectElement->setValue($this->templateFile->getID());
		$this->selectElement->addOption(0, Lang::get('general.choose'));

		foreach ($this->options as $templateOption) {
			$this->selectElement->addOption($templateOption->getID(), $templateOption->getTitle());
		}
		$this->form->addFormElement($this->twitterAccountName->getName(), $this->twitterAccountName);
		$this->form->addFormElement($this->twitterAmount->getName(), $this->twitterAmount);
		$this->form->addFormElement($this->selectElement->getName(), $this->selectElement);

	}

	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping($this->selectElement->getName(), "TemplateFile");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/CmsModuleController#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/twitter/twitterchooser.php');
		$view->assign('form', $this->form);
		$view->assign('identifier', $this->oPageModule->getIdentifier());
		return $view;

	}

	/**
	 * @return boolean
	 */
	public function handleData() {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$templateFile = $this->mapper->getModel($sModIdentifier);

		try {
			Relation::add('pagemodule', 'templatefile', $this->oPageModule, $templateFile);
		} catch (PDOException $e) {
			// trying to add a duplicate
		}
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return $this->oPageModule->getIdentifier();
	}
}