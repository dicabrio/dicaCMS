<?php

Util::import(LIB_DIR.'/modules/auth');

class SecureController implements Controller {

	const C_AUTH_SESSIONNAME = 'CMS';

	protected $arguments;

	public function __construct($sMethod) {
		// we should check for permissions
		// we should check for permissions
		$oAuth = Authentication::getInstance(self::C_AUTH_SESSIONNAME);

		if (!$oAuth->isLoggedIn()) {

			$sMethod = str_replace(array(RequestControllerProtocol::ACTION_DEFAULT, RequestControllerProtocol::ACTION_INDEX), '', $sMethod);
			// set a redirect
			$oSession = Session::getInstance();
			$oSession->set('redirect', $sMethod);

			$this->_redirect('login');
		}
	}

	public function setArguments($arguments) {
		$this->arguments = $arguments;
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