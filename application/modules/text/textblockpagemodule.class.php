<?php

class TextblockPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var CmsController
	 */
	private $page;

	/**
	 *
	 * @param PageModule $oMod
	 * @param Page $oPage
	 * @param Request $request
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->oPageModule = $oMod;
		$this->page = $page;

		// load the data
		$this->load();
	}

	private function load() {
		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
	}

	/**
	 * 
	 * @return string
	 */
	public function getContents() {
		if ($this->oTextContent === null) {
			return '';
		}

		return nl2br($this->oTextContent->getContent());
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}