<?php

class BlogarchiveCmsModule implements CmsModuleController {

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
	 *
	 * @var Bool
	 */
	private $htmlEditor;

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
		$this->load();
	}

	/**
	 * Load the data for this module
	 */
	private function load() {

	}

	/**
	 * add form mapping
	 * 
	 * @param FormMapper $mapper
	 */
	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		return '';
		
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData() {

		// empty

	}

	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
		
	}
}