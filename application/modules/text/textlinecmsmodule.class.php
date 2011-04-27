<?php

class TextlineCmsModule implements CmsModuleController {

	const MAX_LENGTH = 255;

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
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 *
	 * @var int
	 */
	private $maxlength;
	
	/**
	 *
	 * @var Input
	 */
	private $contentFormElement;

	/**
	 * construct the imageupload module
	 *
	 * @param PageModule $module
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $module, Form $form) {

		$this->pageModule = $module;
		$this->form = $form;

		// load the data
		$this->load();
	}

	private function load() {
		
		$this->maxlength = 255;
		$this->label = 'Text Line : '.$this->pageModule->getIdentifier();
		
		$this->getParam('maxlength');
		$this->getParam('label');
		
		$this->textContent = PageText::getByPageModule($this->pageModule);
		$this->contentFormElement = new Input('text', $this->pageModule->getIdentifier(), $this->textContent->getContent());
		$this->form->addFormElement($this->contentFormElement);
		

	}

	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping($this->contentFormElement->getName(), 'TextLine');

	}


	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates').'/text/textline.php');
		$view->assign('maxlength', $this->maxlength);
		$view->assign('identifier', $this->pageModule->getIdentifier());
		$view->assign('form', $this->form);
		$view->assign('label', $this->label);
		
		return $view;
	}

	/**
	 * @todo substract the additional information when exceeds maxlength
	 * 
	 */
	public function handleData() {
		
		$modIdentifier = $this->pageModule->getIdentifier();
		$text = $this->mapper->getModel($modIdentifier);

		$this->textContent->setContent($text);
		$this->textContent->setPageModule($this->pageModule);
		$this->textContent->save();

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