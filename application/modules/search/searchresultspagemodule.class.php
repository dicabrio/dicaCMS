<?php

class SearchresultsPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;
	/**
	 * @var TemplateFile
	 */
	private $templateFile;
	/**
	 * @var Page
	 */
	private $page;
	/**
	 *
	 * @var array
	 */
	private $results;
	/**
	 *
	 * @var Request
	 */
	private $request;

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
		$this->request = $request;
		$this->load();
	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->oPageModule);

		$searchValue = $this->request->request('zoekterm');

		$this->results = array();
		if (!empty($searchValue)) {
			for ($i = 0; $i < 10; $i++) {
				$this->results[] = array(
					'adres' => 'Bartokstraat 68',
					'prijs' => '132000',
					'gcoordinates' => '52.141391,4.469245',
				);
			}
		}
	}

	/**
	 * @return View
	 */
	public function getContents() {

		if ($this->templateFile === null) {
			return '';
		}

		$view = new View(Conf::get('upload.dir.templates') . '/' . $this->templateFile->getFilename());
		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('imagesurl', Conf::get('general.url.images'));
		$view->assign('mediaurl', Conf::get('general.url.www') . Conf::get('upload.url.general'));
		$view->assign('results', $this->results);
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