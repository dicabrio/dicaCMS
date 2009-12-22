<?php

class LoginController implements Controller {

	const C_AUTH_SESSIONNAME = 'CMS';

	public function __construct() {
		// we should check for permissions
	}

	public function setArguments($arguments) {
		$this->arguments = $arguments;
	}


	public function _index() {
		// check for post and handle authentication
		$aErrors = array();
		$oReq = Request::getInstance();
		if (Request::method() == Request::POST) {

			// handle it
			$oAuth = Authentication::getInstance(self::C_AUTH_SESSIONNAME);
			if ($oAuth->login($oReq->post('username'), $oReq->post('password'))) {

				$oSession = Session::getInstance();
				// your are logged in go to next page
				$sRedirect = $oSession->get('redirect');

				if (empty($sRedirect)) {
					$this->_redirect('dashboard');
//					Util::gotoPage(Conf::get('general.url.www').'/'.Conf::get('secure.default_secure_page'));
				} else {
					echo $sRedirect; exit;
					$this->_redirect('dashboard');
//					Util::gotoPage($sRedirect);
				}

			} else {
				$aErrors[] = 'errorusernameorpass';
			}
		}

		$oView = new View('login/login.php');
		$oView->assign('sFormAction', Conf::get('general.url.www'));
		$oView->assign('sUsername', $oReq->post('username'));
		$oView->assign('aErrors', $aErrors);
		return $oView->getContents();

	}

	public function logout() {
		Session::getInstance()->destroy();
		Util::gotoPage(Conf::get('general.url.www').'/login');
	}


	public function _default() {
		return 'this is the default method';
	}

	public function _redirect($url) {
		Util::gotoPage(Conf::get('general.url.www').'/'.$url);
	}
}