<?php

class PagearchiveCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

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
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->pageModule = $oMod;
		$this->form = $form;

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


	}

	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
		
	}
}