<?php

class SpecialpagemenuCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 *
	 * @var TextblockCmsModule
	 */
	private $cmsModuleTextBlock;

	/**
	 *
	 * @var ImageuploadCmsModule
	 */
	private $cmsModuleImageUpload;

	/**
	 *
	 * @param Page $module
	 * @param Form $form
	 *
	 * @return void
	 */
	public function __construct(PageModule $module, Form $form) {

		$this->pageModule = $module;

		$this->cmsModuleTextBlock = new TextblockCmsModule(new SpecialPageModule($module, 1), $form);
		$this->cmsModuleImageUpload = new ImageuploadCmsModule(new SpecialPageModule($module, 2), $form);
		
	}

	/**
	 * This method will return the source of how to edit.
	 * it will return the html code of an textarea or something like that
	 *
	 * @return View
	 */
	public function getEditor() {

//		$views = array($this->cmsModuleTextBlock->getEditor());
		$views = array($this->cmsModuleImageUpload->getEditor(), $this->cmsModuleTextBlock->getEditor());

		$multiView = new View('general/multiview.php');
		$multiView->assign('multiviews', $views);

		return $multiView;

	}

	/**
	 * Handle the validation and saving of the given data for this page. If the module is validated and saved successful.
	 * return true else return false
	 *
	 * @param FormMapper $mapper
	 */
	public function handleData() {

		$this->cmsModuleTextBlock->handleData();
		$this->cmsModuleImageUpload->handleData();

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

		$this->cmsModuleTextBlock->addFormMapping($mapper);
		$this->cmsModuleImageUpload->addFormMapping($mapper);
		
	}

}