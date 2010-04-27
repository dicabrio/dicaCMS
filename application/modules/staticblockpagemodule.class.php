<?php

class StaticblockPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var StaticBlock
	 */
	private $oStaticBlock;

	/**
	 * @var array
	 */
	private $aErrors;

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
	public function __construct(PageModule $oMod, Page $page) {

		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();
		
	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->oStaticBlock = Relation::getSingle('pagemodule', 'staticblock', $this->oPageModule);

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
		$view->assign('mediaurl', Conf::get('general.url.www').Conf::get('upload.url.general'));

		$view->assign('pagename', $this->page->getName());

		return $view;

	}

	/* (non-PHPdoc)
	 * @see modules/Module#validate()
	 */
	public function validate($mData) {

		return true;
		
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData(Request $oReq) {

	}

	/**
	 *
	 * @return array
	 */
	public function getErrors() {

		return $this->aErrors;
		
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
		
	}
}