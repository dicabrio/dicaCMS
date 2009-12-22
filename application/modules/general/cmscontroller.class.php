<?php


class CmsController extends SecureController {

	/**
	 * @var BaseView
	 */
	private $oBaseView;

	/**
	 * @var Menu
	 */
	private $oMainMenu;

	/**
	 * @var Menu
	 */
	private $oSubMenu;

	/**
	 * @var array
	 */
	private $aScripts;

	/**
	 * @var PDO
	 */
	private $oDatabase;

	/**
	 * @param $sMethod
	 * @return void
	 */
	public function __construct($sMethod, $sTitle='') {
		parent::__construct($sMethod);

		$this->oBaseView = new BaseView('baseview.php', $sTitle);

		$this->oMainMenu = new Menu('headerNav');
//		$this->oMainMenu->addItem(new MenuItem('#', '&lt;', '')); // have no function right now
//		$this->oMainMenu->addItem(new MenuItem('#', '&gt;', '')); // have no function right now
		$this->oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').'/dashboard', Lang::get('general.dashboard'), '')); // have no function right now
		$this->oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').'/logout', Lang::get('general.logout'), '')); // have no function right now

		$aMethod = explode('/', $sMethod);
		$sActive = $aMethod[0];
		
		$this->oSubMenu = new Menu('modulesNav');
		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/page/', Lang::get('page.menuname'), 'pages', ($sActive == 'page')));
//		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/media/', 'Media', 'media', ($sActive == 'media')));
//		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/user/', 'Users', 'users', ($sActive == 'user')));
//		$this->oSubMenu->addItem(new MenuItem(Conf::get('general.url.www').'/template/', 'Templates', 'templates', ($sActive == 'template')));

		$this->oBaseView->addMenu('oMainMenu', $this->oMainMenu);
		$this->oBaseView->addMenu('oSubMenu', $this->oSubMenu);

		$this->oBaseView->addScript('jquery.js');

		$this->oDatabase = DataFactory::getInstance('default');
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

	/**
	 * @return PDO
	 */
	public function getConnection() {
		return $this->oDatabase;
	}
}

class CmsException extends Exception {}