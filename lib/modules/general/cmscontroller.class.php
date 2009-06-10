<?php


class CmsController extends SecureController {
	
	/**
	 * @var BaseView
	 */
	private $oBaseView;
	
	private $oMainMenu;
	
	private $oSubMenu;

	/**
	 * @param $sMethod
	 * @return void
	 */
	public function __construct($sMethod, $sTitle='') {
		parent::__construct($sMethod);
		
		$this->oBaseView = new BaseView('baseview.php', $sTitle);
		
		$this->oMainMenu = new Menu('headerNav');
		$this->oMainMenu->addItem(new MenuItem('#', '&lt;', ''));
		$this->oMainMenu->addItem(new MenuItem('#', '&gt;', ''));
		
		$this->oSubMenu = new Menu('modulesNav');
		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/page/', 'Pages', 'pages'));
		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/media/', 'Media', 'media'));
		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/user/', 'Users', 'users'));
		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/template/', 'Templates', 'templates'));
		
		$this->oBaseView->addMenu('oMainMenu', $this->oMainMenu);
		$this->oBaseView->addMenu('oSubMenu', $this->oSubMenu);
	}
	
	/**
	 * @return Menu
	 */
	public function getMainMenu() {
		return $this->oMainMenu;
	}
	
	/**
	 * @return Menu
	 */
	public function getSubMenu() {
		$this->oSubMenu;		
	}
	
	/**
	 * @return BaseView
	 */
	public function getBaseView() {
		return $this->oBaseView;
	}
	
	public function _index() {

	}

	public function _default() {
		return 'CMSController';
	}
}