<?php


class SpecialpagemenuPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @var Request
	 */
	private $request;

	/**
	 *
	 * @param PageModule $module
	 * @param Page $oPage
	 * @param Request $request
	 * @return void
	 */
	public function __construct(PageModule $module, Page $page, Request $request) {

		$this->pageModule = $module;
		$this->page = $page;
		$this->request = $request;

	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$activePages = Page::findActive();

		return '';

	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return '';

	}
	
}