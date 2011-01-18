<?php

class SearchformCmsModule implements CmsModuleController {

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
	 * @var Select
	 */
	private $selectElement;

	/**
	 *
	 * @var FormMapper
	 */
	private $mapper;

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

		$this->load();
		$this->defineForm();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		$this->pages = Page::findActive();


//
//
//
//
//
//		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);
//
//		if ($this->templateFile === null) {
//			$this->templateFile = new TemplateFile();
//		}
//
//		$module = current(Module::getForTemplates('searchresult'));
//		$this->options = TemplateFile::findByModule($module);

	}

	private function defineForm() {

		$this->selectElement = new Select($this->oPageModule->getIdentifier());
		$this->selectElement->setValue((int)$this->oTextContent->getContent());
		$this->selectElement->addOption(0, Lang::get('general.choose'));

		foreach ($this->pages as $page) {
			$this->selectElement->addOption($page->getID(), $page->getName());
		}

		$this->form->addFormElement($this->selectElement->getName(), $this->selectElement);

	}

	public function addFormMapping(FormMapper $mapper) {

		$mapper->addFormElementToDomainEntityMapping($this->selectElement->getName(), "Page");
		$this->mapper = $mapper;

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/search/searchresultstemplatechooser.php');
		$view->assign('form', $this->form);
		$view->assign('identifier', $this->oPageModule->getIdentifier());

		return $view;

	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData() {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$searchLandingPage = $this->mapper->getModel($sModIdentifier);

		$this->oTextContent->setContent($searchLandingPage->getID());
		$this->oTextContent->setPageModule($this->oPageModule);
		$this->oTextContent->save();

		return false;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}