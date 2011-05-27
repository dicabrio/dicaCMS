<?php

class TextlinePageModule implements PageModuleController {
	
	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var PageText
	 */
	private $textContent;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->pageModule = $oMod;
		$this->load();
		
	}

	private function load() {

		$this->textContent = PageText::getByPageModule($this->pageModule);
		
	}
	
	/**
	 * @return string
	 */
	public function getContents() {

		return $this->textContent->getContent();
		
	}

	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}
}