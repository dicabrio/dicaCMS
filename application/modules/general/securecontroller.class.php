<?php

class SecureController implements Controller {

	protected $arguments;

	/**
	 *
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
		Util::gotoPage(Conf::get('general.url.www').'/'.$page);
	}
}