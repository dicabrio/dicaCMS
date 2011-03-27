<?php

class IncludestaticblockPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var StaticBlock
	 */
	private $oStaticBlock;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();
		
	}

	/**
	 * load the needed information
	 */
	private function load() {

		$blocks = StaticBlock::findByIdentifier($this->oPageModule);
		if (count($blocks) > 0) {
			$this->oStaticBlock = reset($blocks);
		}
		
	}

	/**
	 * @return View
	 */
	public function getContents() {

		if ($this->oStaticBlock === null) {
			return '';
		}
		
		$view = $this->oStaticBlock->getView();

		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('imagesurl', Conf::get('general.url.images'));
		$view->assign('cssurl', Conf::get('general.url.css'));
		$view->assign('jsurl', Conf::get('general.url.js'));
		$view->assign('mediaurl', Conf::get('general.url.www').Conf::get('upload.url.general'));

		$view->assign('pagename', $this->page->getName());

		return $view;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
		
	}
}