<?php

/**
 * @package Pagemoduletemplate 
 * @author Robert Cabri <robert@dicabrio.com>
 * 
 * This is a template for a page module
 * Just copy it, rename it to your own module you would like to
 * have. 
 * 
 * This class is used for the frontend
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
class PagemoduletemplatePageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var Page
	 */
	private $page;
	/**
	 *
	 * @var Request
	 */
	private $request;
	/**
	 * As the above example states this $label will have the value of foo. 
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
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->request = $request;
		$this->pageModule = $oMod;
		$this->page = $page;

		$this->getParam('label');
	}

	/**
	 * @return View
	 */
	public function getContents() {

		return "hello world i'v added a label : " . $this->label;
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