<?php

class TextlinePageModule implements PageModuleController {
	
	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->oPageModule = $oMod;
		$this->load();
		
	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		
	}
	
	/**
	 * @return string
	 */
	public function getContents() {

		return $this->oTextContent->getContent();
		
	}

	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}