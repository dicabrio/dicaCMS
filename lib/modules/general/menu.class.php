<?php



class Menu {

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
	 * @param string $sIdentifier
	 * @param string $sTemplateFilename
	 */
	public function __construct($sIdentifier, $sTemplateFilename='') {
		$this->oView = new View('menu/menu.php');
		$this->oView->assign('sIdentifier', $sIdentifier);
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

}
