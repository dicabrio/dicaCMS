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
			$oSession->set('redirect', Conf::get('general.url.www').'/'.$sMethod);
			Util::gotoPage(Conf::get('general.url.www').'/login');
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

	public function logout() {
		Util::gotoPage(Conf::get('general.url.www').'/logout');
	}

	public function _redirect($url) {
		Util::gotoPage(DOMAIN.$url);
	}
}