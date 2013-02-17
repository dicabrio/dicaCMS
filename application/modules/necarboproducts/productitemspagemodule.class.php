<?php

class ProductitemsPageModule implements PageModuleController {

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
	 * @var Region
	 */
	private $region;

	/**
	 *
	 * @var Productgroup
	 */
	private $group;
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
		$this->region = Region::findByBody(REGION); // hack to import the classes
		$this->group = new Productgroup($this->request->get('group'));
	}

	private function buildTableRow(Product $p) {

		$appliContent = array();
		foreach ($p->getApplications() as $app) {
			$appliContent[] = $app->getDescription();
		}

		$appliContent = implode(', ', $appliContent);

		$table = '<tr>';
		$table .= '<td>'.$p->getName().'<br /><p style="font-size: 10px">'.$appliContent.'</p></td>';
		$table .= '<td style="width: 45px; padding: 0 0 10px 0;"><a href="'.Conf::get('general.url.www').'/files/MSDS/'.Lang::getLang().'/'.($p->getMsdsFilename()).'"><img src="'.Conf::get('general.url.www').'/images/download.png" alt="'.$p->getMsdsFilename().'" /></a></td>';
		$table .= '<td><a href="'.Conf::get('general.url.www').'/files/PDS/'.Lang::getLang().'/'.($p->getPdsFilename()).'"><img src="'.Conf::get('general.url.www').'/images/download.png" alt="'.$p->getPdsFilename().'" /></a></td>';
		$table .= '</tr>';
		return $table;
	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$search = $this->request->post('productsearch');
		if (!empty($search)) {
			$products = Product::findByKeyword($search);
		} else {
			$products = Product::findByGroup($this->group);
		}


		$table = '<table style="width: 100%">';
		$table .= '<tr>';
		$table .= '<td><strong>'.$this->group->getName().'</strong></td>';
		$table .= '<td>MSDS</td>';
		$table .= '<td>PDS</td>';
		$table .= '</tr>';
		foreach ($products as $product) {
			$table .= $this->buildTableRow($product);
		}


		$table .= '</table>';

		return $table;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return '';
	}

}