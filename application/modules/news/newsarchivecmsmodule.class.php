<?php

class NewsarchiveCmsModule implements CmsModuleController {
	const MAX_LENGTH = 255;

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var int
	 */
//	private $page;
	/**
	 * @var Form
	 */
	private $form;
	/**
	 * @var FormMapper
	 */
	private $mapper;
	/**
	 * @var PageText
	 */
	private $amount;
	private $type;
	private $template;

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
		$this->load();
	}

	/**
	 * Load the data for this module
	 */
	private function load() {

		$this->type = 'news';
		$this->template = new TemplateFile();
		$this->amount = -1; // all

		$this->getParam('type');
		$this->getParam('template');
		$this->getParam('amount');
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
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