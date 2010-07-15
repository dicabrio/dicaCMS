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
	 *
	 * @param string $sScript
	 * @return void
	 */
	public function addScript($sScript) {
		if (!is_string($sScript)) {
			throw new CmsException('It is not allowed to add a script url of another type then string. Type is: '.getType($sScript));
		}
		$this->aScripts[] = $sScript;
	}

	/**
	 * @param Link $sLink
	 */
	public function addStyle($sLink) {
		if (!is_string($sLink)) {
			throw new CmsException('It is not allowed to add a style url of another type then string. Type is: '.getType($sLink));
		}
		
		$this->aStyles[] = $sLink;
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