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
	public function __construct($method) {
		// we should check for permissions
		$this->session = Session::getInstance();
		$oAuth = Authentication::getInstance();
		$user = $oAuth->getUser();

		if ($this instanceof LoginController) {
			return;
		}

		$method = str_replace(array(RequestControllerProtocol::ACTION_DEFAULT, RequestControllerProtocol::ACTION_INDEX), '', $method);
		$area = Area::findByName($method, 'CMS');

		if ($area->getID() == 0) {
			$this->createArea($area, $method);
		}

		try {
			$user->watch($area);
		} catch (Exception $e) {
			$this->session->set('redirect', $method);
			$this->_redirect($area->getUrl());
		}

	}

	private function createArea(Area $area, $method) {

		$data = DataFactory::getInstance();
		$data->beginTransaction();
		try {
			$defaultGroup = UserGroup::findByName('admin');
			$area->setName($method);
			$area->setUrl('login');
			$area->setType('CMS');
			$area->addUserGroup($defaultGroup);
			$area->save();
			$data->commit();
		} catch (PDOException $e) {
			$data->rollBack();
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