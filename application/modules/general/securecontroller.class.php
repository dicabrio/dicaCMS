<?php

class SecureController implements Controller {

	protected $arguments;

	/**
	 * @var Session
	 */
	private $session;

	/**
	 *
	 * @param string $sMethod
	 */
	public function __construct($sMethod) {
		// we should check for permissions
		$this->session = Session::getInstance();
		$oAuth = Authentication::getInstance(Authentication::C_AUTH_SESSIONNAME);

		if (!$oAuth->isLoggedIn() && !($this instanceof LoginController)) {

			$sMethod = str_replace(array(RequestControllerProtocol::ACTION_DEFAULT, RequestControllerProtocol::ACTION_INDEX), '', $sMethod);
			// set a redirect
			$this->session->set('redirect', $sMethod);

			$this->_redirect('login');
		}
		
		
		try {

			$uri_string = trim($sMethod, '/');
			$areaName = $uri_string;
			if (!empty($uri_string)) {

				$uriStringExploded = explode('/', $uri_string);
				$controller = array_shift($uriStringExploded);
				$method = array_shift($uriStringExploded);
				$areaName = trim($controller.'/'.$method, '/');
			}

			$area = Area::findByName($areaName, Conf::get('area.area_type_cms'));
			if ($area->getID() == 0) {
				$this->createArea($area, $areaName);
			}

			$user = $oAuth->getUser();
//			$user = User::loadFromSession($this->app->getSession());
			$user->watch($area);
			$this->user = $user;

		} catch (Exception $e) {

			$this->getSession()->set(CmsController::KEY_CMS_REDIRECT, $uri_string);
			$this->getResponse()->redirect($this->app->config('core/routing.base_url').'/'.$area->getUrl()); // @todo add redirect method
		}
	}
	
	private function createArea(Area $area, $method) {

		$this->pdo->beginTransaction();

		try {

			$defaultGroup = UserGroup::findByName($this->app->config('area/area.default_user_group'));
			$area->setName($method);
			$area->setUrl($this->app->config('area/area.default_redirect'));
			$area->setType($this->app->config('area/area.area_type_cms')); //
			$area->addUserGroup($defaultGroup);
			$area->save();

			$this->pdo->commit();
		} catch (PDOException $e) {

			$this->pdo->rollBack();
		}
	}

	public function setArguments($arguments) {
		$this->arguments = $arguments;
	}

	/**
	 *
	 * @return Session
	 */
	public function getSession() {

		return $this->session;

	}


	public function _index() {
		return '_index';
	}


	public function _default() {
		return '_default';
	}

	/**
	 * redirect to the logout page
	 */
	public function logout() {
		$this->_redirect('logout');
	}

	/**
	 * redirect to a certain page. No host prefix.
	 *
	 * example:
	 *	- dashboard
	 *	- pages
	 *
	 * NOT:
	 *	- http://domain.com/test/
	 *
	 * @param string $page
	 */
	public function _redirect($page) {
		Util::gotoPage(Conf::get('general.cmsurl.www').'/'.$page);
	}
}