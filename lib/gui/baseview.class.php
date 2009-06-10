<?php

class BaseView extends View {

	private $aScripts = array();

	private $aStyles = array();

	private $aMenus = array();

	/**
	 * @param string $sView template file
	 * @param string $sTitle title of the page. default is ''
	 */
	public function __construct($sView, $sTitle='') {
		parent::__construct($sView);
		$this->assign('sTitle', $sTitle);
	}

	/**
	 * @param Link $oLink
	 */
	public function addScript(Link $oLink) {
		$this->aScripts[] = $oLink;
	}

	/**
	 * @param Link $oLink
	 */
	public function addStyle(Link $oLink) {
		$this->aStyles[] = $oLink;
	}

	/**
	 * @param string $sKey
	 * @param Menu $oMenu
	 */
	public function addMenu($sKey, Menu $oMenu) {
		$this->aMenus[$sKey] = $oMenu;
	}

	/**
	 * @param string $sKey
	 * @return Menu
	 */
	public function getMenu($sKey) {
		if (!isset($this->aMenus[$sKey])) {
			throw new KeyNotFoundException('Menu '.$sKey.' could not be found in the menu list');
		}

		return $this->aMenus[$sKey];
	}

	/**
	 * @return string
	 */
	public function getContents() {

		foreach ($this->aMenus as $sKey => $oMenu) {
			$this->assign($sKey, $oMenu);
		}

		$this->assign('aScripts', $this->aScripts);
		$this->assign('aStyles', $this->aStyles);

		return parent::getContents();
	}
}