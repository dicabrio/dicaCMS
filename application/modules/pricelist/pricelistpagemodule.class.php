<?php

class PricelistPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

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
	 * @var XMLFeed
	 */
	private $xmlFeed;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->request = $request;
		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->xmlFeed = XMLFeed::getByPageModule($this->oPageModule);

	}

	/**
	 * @return View
	 */
	public function getContents() {

		if ($this->xmlFeed === null) {
			return "";
		}

		$priceList = new PriceListXML($this->xmlFeed->getSource());
		$priceList->addTemplate(new View('pricelist.xls'));

		return $priceList->getContents();

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();

	}

}