<?php

class IncludestaticblockCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

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

		$this->oPageModule = $oMod;
		$this->form = $form;

	}

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