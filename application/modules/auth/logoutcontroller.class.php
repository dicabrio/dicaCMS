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
		// check for post and handle authentication
		$sError = '';
		$oTpl = new Template();
		$oTpl->setTemplateFile('/login/login.html');
		$oTpl->assign('formaction', WWW_URL.'/login/');
		$oTpl->assign('username', '');
		$oTpl->assign('error', $sError);
		return $oTpl->getContents();

	}


	public function _default() {
		return 'this is the default method';
	}
}