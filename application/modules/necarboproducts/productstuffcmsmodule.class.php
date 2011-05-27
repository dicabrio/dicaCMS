<?php

class ProductstuffCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 *
	 * @param Page $module
	 * @param Form $form
	 *
	 * @return void
	 */
	public function __construct(PageModule $module, Form $form) {

		$this->pageModule = $module;

	}

	/**
	 * This method will return the source of how to edit.
	 * it will return the html code of an textarea or something like that
	 *
	 * @return View
	 */
	public function getEditor() {
		return '';
	}

	/**
	 * Handle the validation and saving of the given data for this page. If the module is validated and saved successful.
	 * return true else return false
	 *
	 * @param FormMapper $mapper
	 */
	public function handleData() {

	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}

	/**
	 *
	 * @param FormMapper $mapper
	 */
	public function addFormMapping(FormMapper $mapper) {

	}

}