<?php

class ActionMenu {

	/**
	 * @var array
	 */
	private $menuitems = array();
	/**
	 * @var View
	 */
	private $oView;

	/**
	 * Enter description here...
	 *
	 * @param string $identifier
	 * @param string $sTemplateFilename
	 */
	public function __construct($identifier, $sTemplateFilename='') {
		$this->oView = new View(Conf::get('general.dir.templates').'/menu/menu.php');
		$this->oView->assign('identifier', $identifier);
	}

	/**
	 * @param MenuItem $oItem
	 */
	public function addItem(MenuItem $oItem) {
		$this->menuitems[] = $oItem;
	}

	/**
	 * @return string
	 */
	public function getContents() {

		$this->oView->assign('menuItems', $this->menuitems);
		return $this->oView->getContents();
	}

	public function __toString() {
		try {
			return $this->getContents();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

}
