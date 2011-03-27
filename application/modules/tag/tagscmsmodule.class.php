<?php

class TagsCmsModule implements CmsModuleController {

	const MAX_LENGTH = 255;

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var int
	 */
	private $page;

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
	public function __construct(PageModule $module, Form $form) {

		$this->pageModule = $module;
		$this->form = $form;


	}

	public function addFormMapping(FormMapper $mapper) {

		// left intentionaly empty
		$this->mapper = $mapper;

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		return new View(Conf::get('general.dir.templates').'/general/empty.php');

	}

	/**
	 * @return boolean
	 */
	public function handleData() {

		return true;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}
}