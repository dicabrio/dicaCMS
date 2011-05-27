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
class PagemoduletemplateCmsModule implements CmsModuleController {

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

		$this->getParam('label');
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

		$view = new View(Conf::get('general.dir.templates') . '/general/empty.php');
		return $view;
	}

	/**
	 * Handle the data. Saving/deleting/updating
	 * @return void
	 */
	public function handleData() {
		
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