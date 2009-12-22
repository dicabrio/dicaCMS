<?php

class LogoutController implements Controller {

	public function __construct() {
		// we should check for permissions
	}

	public function setArguments($arguments) {
		$this->arguments = $arguments;
	}


	public function _index() {
		// getting the session
		$oSession = Session::getInstance();
		$oSession->destroy();

		$this->_redirect('login');

	}


	public function _default() {
		return 'this is the default method';
	}

	public function _redirect($url) {
		Util::gotoPage(Conf::get('general.url.www').'/'.$url);
	}
}