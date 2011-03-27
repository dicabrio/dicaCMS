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

		$this->oBaseView = new BaseView(Conf::get('general.dir.templates').'/baseview.php', $sTitle);

		$this->oMainMenu = new Menu('headerNav');
//		$this->oMainMenu->addItem(new MenuItem('#', '&lt;', '')); // have no function right now
//		$this->oMainMenu->addItem(new MenuItem('#', '&gt;', '')); // have no function right now
		$this->oMainMenu->addItem(new MenuItem(Conf::get('general.cmsurl.www').'/dashboard', Lang::get('general.dashboard'), '')); // have no function right now
//		$this->oMainMenu->addItem(new MenuItem(Conf::get('general.cmsurl.www').'/settings', Lang::get('general.settings'), '')); // have no function right now
		$this->oMainMenu->addItem(new MenuItem(Conf::get('general.cmsurl.www').'/logout', Lang::get('general.logout'), '')); // have no function right now
		$this->oMainMenu->addItem(new MenuItem(Conf::get('general.url.www'), Lang::get('general.got-website'), '')); // have no function right now

		$aMethod = explode('/', $sMethod);
		$sActive = $aMethod[0];

		$moduleMenu = Module::getMenu();

		$this->oSubMenu = new Menu('modulesNav');
		foreach ($moduleMenu as $module) {
			$menuItem = new MenuItem(
					Conf::get('general.cmsurl.www').$module->getUrl(),
					Lang::get($module->getName().'.menuname'),
					$module->getName(),
					($sActive == $module->getName()));
			$this->oSubMenu->addItem($menuItem);

		}

		$this->oBaseView->addMenu('oMainMenu', $this->oMainMenu);
		$this->oBaseView->addMenu('oSubMenu', $this->oSubMenu);

		$this->oBaseView->addScript(Conf::get('general.url.js').'/jquery.js');
		$this->oBaseView->addScript(Conf::get('general.url.js').'/jquery-ui.min.js');
		$this->oBaseView->addScript(Conf::get('general.url.js').'/general.js');

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

class CmsException extends Exception {

}