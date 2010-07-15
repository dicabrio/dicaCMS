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
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 * @var CmsController
	 */
	private $oCmsController;

	/**
	 *
	 * @var array
	 */
	private $options;

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

		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);
		if ($this->templateFile == null) {
			$this->templateFile = new TemplateFile();
		}

		$module = current(Module::getForTemplates('twitter'));
		$this->options = TemplateFile::getFiles($module);

	}

	private function defineForm() {

		$selectTemplate = new Select($this->oPageModule->getIdentifier());
		$selectTemplate->setValue($this->templateFile->getID());
		$selectTemplate->addOption(0, Lang::get('general.choose'));

		foreach ($this->options as $templateOption) {
			$selectTemplate->addOption($templateOption->getID(), $templateOption->getTitle());
		}
		$this->form->addFormElement($selectTemplate->getName(), $selectTemplate);
		$this->mapper->addFormElementToDomainEntityMapping($selectTemplate->getName(), "TemplateFile");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/CmsModuleController#getEditor()
	 */
	public function getEditor() {

		$view = new View('twitter/twitterchooser.php');
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

//		exit;
//		$blockID = (int)$oReq->post($sModIdentifier);
//		if ($this->validate($blockID)) {
//			if ($blockID > 0) {
//				$block = new TemplateFile($blockID);
//
//				
//			}
//			return true;
//		}

//		return false;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return $this->oPageModule->getIdentifier();
	}
}