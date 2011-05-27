<?php

class PagerelatedCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var PageText
	 */
	private $textContent;

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
	 * @var string
	 */
	private $amount;

	/**
	 *
	 * @var string
	 */
	private $type;

	/**
	 *
	 * @var string
	 */
	private $template;

	/**
	 *
	 * @var array
	 */
	private $pages;

	/**
	 *
	 * @var array
	 */
	private $relatedPages;
	
	/**
	 *
	 * @var string
	 */
	private $label;

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

		// load the data
		$this->load();
		$this->defineForm();
	}

	/**
	 * Load the data for this module
	 */
	private function load() {

		$this->type = 'all';
		$this->template = 'empty';
		$this->amount = '-1';
		$this->label = 'Related Pages';

		$this->getParam('type');
		$this->getParam('template');
		$this->getParam('amount');
		$this->getParam('label');

		$this->pages = Page::findActive($this->amount, 0, $this->type, 'ASC');

		$this->textContent = PageText::getByPageModule($this->pageModule);
		$this->relatedPages = explode(',', $this->textContent->getContent());

	}

	private function defineForm() {

		foreach ($this->pages as $page) {
			$element = new CheckboxInput($this->getIdentifier().'_relatedpages[]', $page->getID());
			$element->setValue($this->relatedPages);
			$this->form->addFormElement($element);
		}
	}

	/**
	 * add form mapping
	 * 
	 * @param FormMapper $mapper
	 */
	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping($this->getIdentifier().'_relatedpages', 'PageCollection');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/pagerelated/pagerelatedmodule.php');
		$view->assign('pages', $this->pages);
		$view->assign('form', $this->form);
		$view->assign('identifier', $this->pageModule->getIdentifier());
		$view->assign('label', $this->label);

		return $view;
		
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData() {

		$relatedPages = array();
		$col = $this->mapper->getModel($this->getIdentifier().'_relatedpages');

		foreach ($col as $index => $item) {
			if ($item->isSelected()) {
				$relatedPages[$item->getValue()] = trim($item->getValue());
			}
		}

		$this->textContent->setContent(implode(',', $relatedPages));
		$this->textContent->setPageModule($this->pageModule);
		$this->textContent->save();
	}

	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
		
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}
}