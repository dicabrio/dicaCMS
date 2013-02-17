<?php

/**
 * @package Pagemoduletemplate 
 * @author Robert Cabri <robert@dicabrio.com>
 * 
 * This is a template for a page module
 * Just copy it, rename it to your own module you would like to
 * have. 
 * 
 * This class is used for the backend
 * 
 * usage in your template:
 * 
 * [[<modulename>:<identifier> <parameter name>="<parameter value>"]]
 * 
 * in this case:
 * [[pagemoduletemplate:my_identifier label="foo"]]
 * 
 * 
 * 
 */
class PagelistCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var Form
	 */
	private $form;
	/**
	 * @var FormMapper
	 */
	private $mapper;
	/**
	 * As the above example states this $label will have the value of foo. 
	 * 
	 * @var string
	 */
	private $label;
	/**
	 * @var string
	 */
	private $pagetype;
	/**
	 * @var string
	 */
	private $template;
	/**
	 *
	 * @var PageText
	 */
	private $selectedPages;
	
	/**
	 *
	 * @var string
	 */
	private $custompagemodule;

	/**
	 * construct the imageupload module
	 *
	 * @param PageModule $oMod
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->pageModule = $oMod;
		$this->form = $form;
		
		$this->load();
		
	}
	
	private function load() {
		
		$this->pagetype = 'all';
		$this->template = 'empty';
		$this->label = 'Page list : '.$this->pageModule->getIdentifier();

		$this->getParam('label');
		$this->getParam('pagetype');
		$this->getParam('template');
		
		$this->selectedPages = PageText::getByPageModule($this->pageModule);
		
		$pages = Page::findActive(-1, 0, $this->pagetype);
		
		$pageSelectBox = new Select('pagelist_pages');
		$pageSelectBox->addOption('', Lang::get('pagelist.choose'));
		foreach ($pages as $page) {
			$pageSelectBox->addOption($page->getID(), $page->getName());
		}
		$this->form->addFormElement($pageSelectBox);
		
		$pagesSelectedInputHolder = new Input('hidden', $this->pageModule->getIdentifier(), $this->selectedPages->getContent());
		$this->form->addFormElement($pagesSelectedInputHolder);
	}

	/**
	 * This method will be called by the PageController when saving a page.
	 * You can add mapping for this specific module.
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

		$view = new View(Conf::get('general.dir.templates') . '/pagelist/pagelistmodule.php');
		$view->assign('form', $this->form);
		$view->assign('identifier', $this->pageModule->getIdentifier());
		$view->assign('label', $this->label);
		return $view;
	}

	/**
	 * Handle the data. Saving/deleting/updating
	 * @return void
	 */
	public function handleData() {
		
		$selectedPages = $this->mapper->getModel($this->pageModule->getIdentifier());
		
		if ($this->selectedPages === null) {
			$this->selectedPages = new PageText();
		}
		
		$this->selectedPages->setContent((string)$selectedPages);
		$this->selectedPages->setPageModule($this->pageModule);
		$this->selectedPages->save();
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}

	/**
	 *
	 * @param string $name 
	 */
	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

}