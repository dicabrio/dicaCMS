<?php

class ProductsearchPageModule implements PageModuleController {

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

	private $products;

	private $region;

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
		$this->region = 'eu';
		$this->productfacts = 'productfacts';
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

	private function getRegions() {

		$this->getParam('region');
		$this->getParam('productfacts');

		$region = Region::findByBody(REGION);

		$productGroups = $this->getProductGroups($region);

		return $productGroups;
	}

	private function getProductGroups(Region $region) {

		$productGroups = $region->getProductGroup();

		while ($group = array_shift($productGroups)) {

			$parent_id = $group->getParentID();

			if ($parent_id == 0) {
				break;
			}

			if (isset($productGroups[$parent_id])) {
				$productGroups[$parent_id]->addChild($group);
			}
		}

		return ($this->displayChildren($group, 0, 2));
	}

	private function displayChildren(Productgroup $g, $currentlevel=0, $levelsDeep = -1) {

		if ($levelsDeep != -1 && $levelsDeep == $currentlevel) {
			return '';
		}

		if ($currentlevel == 0) {
			$test = '<ul class="submenu">';
		} else {
			$test = '<ul>';
		}
		foreach ($g->getChildren() as $group) {

			$active = '';
			if ($group->getID() == $this->request->get('group')) {
				$active = ' class="active"';
			}

			$test .= '<li' . $active . '><a href="'.Conf::get('general.url.www').'/'.$this->productfacts.'?group=' . $group->getID() . '">';
			$test .= $group->getName() . '</a>';
			$test .= $this->displayChildren($group, $currentlevel + 1, $levelsDeep);
			$test .= '</li>';
		}
		$test .='</ul>';

		return $test;
	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$output = '
<form method="post" action="'.Conf::get('general.url.www').'/'.$this->productfacts.'" >
<input name="productsearch" value="" type="text" style="width: 196px; padding: 5px; margin: 0 0 10px 0; border: 2px solid #d1d3d4;" />
<input style="float: right;" type="submit" name="submit" value="'.Lang::get('general.button.search').'" />
</form>';
		return $output;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return '';
	}

}