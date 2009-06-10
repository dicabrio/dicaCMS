<?php



class Menu extends View {
	
	/**
	 * @var array
	 */
	private $aMenuItems = array();
	
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
		$this->aMenuItems[] = $oItem;
	}
	
	/**
	 * @return string
	 */
	public function getContents() {
		
		$this->oView->assign('aMenuItems', $this->aMenuItems);
		return $this->oView->getContents();
	}
	
}
