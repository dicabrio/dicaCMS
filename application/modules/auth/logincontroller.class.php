<?php
/**
 * LoginController
 *
 * @desc This controller will let you login to the application
 */
class LoginController implements Controller {

	

	public function __construct() {
		// we should check for permissions
	}

	public function setArguments($arguments) {
		$this->arguments = $arguments;
	}

	/**
	 * Inital login screen request
	 * 
	 * @return string
	 */
	public function _index() {

		$aErrors = array();
		$oReq = Request::getInstance();

		$form = new LoginForm($oReq);
		$form->listen();
		
		$oView = new View('login/login.php');
		$oView->assign('form', $form);
		$oView->assign('aErrors', $form->getMapper()->getMappingErrors());
		return $oView->getContents();

	}

	/**
	 * Logout request. When logged out it redirects to
	 * the initial login screen
	 */
	public function logout() {
		Session::getInstance()->destroy();
		$this->_redirect('login');
	}

	/**
	 * doesn't do very much
	 * 
	 * @return string
	 */
	public function _default() {
		return 'this is the default method';
	}

	/**
	 * @TODO remove from controller shizzle like stuff
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