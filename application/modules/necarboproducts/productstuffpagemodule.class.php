<?php

class ProductstuffPageModule implements PageModuleController {

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
	 * @var array
	 */
	private $groups;

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

		$regions = Region::find();
		$this->getParam('region');
		$this->getParam('productfacts');

		$output = '<ul class="submenu">';
		foreach ($regions as $region) {
			$children = '';
			$active = '';
			if ($this->request->get('region') == $region->getID()) {
				$active = 'class="active"';
				$children = $this->getProductGroups($region);
			}

			$output .= '
				<li ' . $active . '>
					<a href="' . Conf::get('general.url.www') . '/productfacts?region=' . $region->getID() . '">' . $region->getName() . '</a>
					' . $children . '
				</li>';
		}
		$output .= '</ul>';


//		$region = Region::findByBody(REGION);
//		$productGroups = $this->getProductGroups($region);

		return $output;
	}

	private function getGroupsToDisplay() {

		$gid = $this->request->get('group');
		$g = new Productgroup($this->request->get('group'));

		$this->groups = array($gid);
		while (0 != $g->getParentID()) {
			$this->groups[] = $g->getParentID();
			$g = $g->getParent();
		}
	}

	private function getProductGroups(Region $region) {

		$productGroups = $region->getProductGroup();

		while ($group = array_shift($productGroups)) {
			if ($group->getParentID() == 0) {
				break;
			}
		}

		$this->getGroupsToDisplay($group);

		return ($this->displayChildren($group, 0, 2));
	}

	private function displayChildren(Productgroup $g, $currentlevel=0, $levelsDeep = -1) {

		if ($levelsDeep != -1 && $levelsDeep == $currentlevel) {
			return '';
		}

		if ($currentlevel != 0 && !in_array($g->getID(), $this->groups)) {
			return '';
		}
		
		$test = '<ul>';
		foreach ($g->getChildren() as $group) {

			if ($currentlevel == 1 && count(Product::findByGroup($group)) == 0) {
				continue;
			}

			$active = '';
			if ($group->getID() == $this->request->get('group')) {
				$active = ' class="active"';
			}

			$test .= '<li' . $active . '>';
			$test .= '<a href="' . Conf::get('general.url.www') . '/' . $this->productfacts . '?region='.intval($this->request->get('region')).'&group=' . $group->getID() . '">';
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

		return $this->getRegions();
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return '';
	}

}