<?php

class PagearchiveCmsModule implements CmsModuleController {

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
	 * @var Input
	 */
	private $amountElement;

	private $amount;

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
		$this->htmlEditor = false;

		// load the data
//		$this->load();
//		$this->defineForm();
	}

	/**
	 * Load the data for this module
	 */
	private function load() {

//		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
//		$values = explode(',', $this->oTextContent->getContent());
//
//		$this->type = null;
//		if (!isset($values[1])) {
//			$this->amount = -1;
//			$this->templateFile = new TemplateFile();
//		} else {
//			$this->amount = $values[0];
//			$this->templateFile = new TemplateFile($values[1]);
//		}
//
//		if (isset($values[2]) && !empty($values[2])) {
//			$this->type = $values[2];
//		}
//
//		$module = current(Module::getForTemplates('pagelist'));
//		$this->options = TemplateFile::findByModule($module);
	}

	private function defineForm() {

//		$this->amountElement = new Input('text', $this->oPageModule->getIdentifier().'_amount', $this->amount);
//
//		$this->selectElement = new Select($this->oPageModule->getIdentifier());
//		$this->selectElement->setValue($this->templateFile->getID());
//		$this->selectElement->addOption(0, Lang::get('general.choose'));
//
//		$this->typeElement = new Select($this->oPageModule->getIdentifier().'_type');
//		$this->typeElement->setValue($this->type);
//		$this->typeElement->addOption(0, Lang::get('general.choose'));
//		$this->typeElement->addOption('all', 'All types');
//		$this->typeElement->addOption('basis', 'Page');
//		$this->typeElement->addOption('blog', 'Cases');
//		$this->typeElement->addOption('partner', 'Partners');
//		$this->typeElement->addOption('sales', 'Sales');
//
//		foreach ($this->options as $templateOption) {
//			$this->selectElement->addOption($templateOption->getID(), $templateOption->getTitle());
//		}
//		$this->form->addFormElement($this->amountElement);
//		$this->form->addFormElement($this->selectElement);
//		$this->form->addFormElement($this->typeElement);
	}

	/**
	 * add form mapping
	 * 
	 * @param FormMapper $mapper
	 */
	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
//		$this->mapper->addFormElementToDomainEntityMapping($this->selectElement->getName(), "TemplateFile");
//		$this->mapper->addFormElementToDomainEntityMapping($this->typeElement->getName(), "DomainText");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		return '';

//		$view = new View(Conf::get('general.dir.templates').'/page/pagearchivecmsmodule.php');
//		$view->assign('form', $this->form);
//		$view->assign('identifier', $this->oPageModule->getIdentifier());
//
//		return $view;
		
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData() {

//		$sModIdentifier = $this->oPageModule->getIdentifier();
//		$templateFile = $this->mapper->getModel($sModIdentifier);
//		$amount = $this->mapper->getModel($sModIdentifier.'_amount');
//		$type = $this->mapper->getModel($sModIdentifier.'_type');
//
//		$this->oTextContent->setContent($amount.','.$templateFile->getID().','.$type);
//		$this->oTextContent->setPageModule($this->oPageModule);
//		$this->oTextContent->save();

	}

	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
		
	}
}