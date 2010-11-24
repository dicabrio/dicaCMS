<?php

class SpecialPageModule extends PageModule {

	/**
	 *
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var int
	 */
	private $number;

	/**
	 * Decorator for a normal page module
	 *
	 * @param PageModule $pageModule
	 * @param int $number
	 */
	public function __construct(PageModule $pageModule, $number) {
		$this->pageModule = $pageModule;
		$this->number = $number;
	}

	public function getID() {
		return $this->pageModule->getID();
	}

	/**
	 * get the module identifier
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier().'_'.$this->number;
		
	}

	/**
	 * @param string $sIdentifier
	 * @return void
	 */
	public function setIdentifier($sIdentifier) {
		
	}

	/**
	 * @param Page $oPage
	 * @return void
	 */
	public function setPage(Page $oPage) {
		
	}

	/**
	 * This is the module type.
	 * Examples: TextBlock, TextLine, StaticBlock, etc
	 *
	 * @return string
	 */
	public function getType() {

		return $this->pageModule->getType();
		
	}

	/**
	 * @param string $sType
	 * @return void
	 */
	public function setType($sType) {
		
	}
}

