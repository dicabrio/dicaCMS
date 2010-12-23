<?php
/**
 * LoginController
 *
 * @desc This controller will let you login to the application
 */
class LoginController extends CmsController {

	/**
	 * @var Form
	 */
	private $form;

	/**
	 * @var FormMapper
	 */
	private $formMapper;

	/**
	 *
	 */
	public function __construct($method) {

		parent::__construct($method, 'Login');
		// we should check for permissions
		$this->form = new LoginForm(Conf::get('general.url.www').'/login/accept');
		$this->formMapper = new LoginMapper();

	}

	/**
	 * Inital login screen request
	 *
	 * @return string
	 */
	public function _index() {

		$oView = new View(Conf::get('general.dir.templates').'/login/login.php');
		$oView->assign('form', $this->form);
		$oView->assign('errors', $this->formMapper->getMappingErrors());

		return $oView->getContents();

	}

	/**
	 * do the actual login check
	 * 
	 * @return string
	 */
	public function accept() {

		try {

			$this->form->listen(Request::getInstance());
			$this->formMapper->constructModelsFromForm($this->form);

			$oAuth = Authentication::getInstance(Authentication::C_AUTH_SESSIONNAME);
			if ($oAuth->login($this->formMapper->getModel('username'), $this->formMapper->getModel('password'))) {

				// your are logged in go to next page
				$redirect = $this->getSession()->get('redirect');

				if (empty($redirect)) {
					$redirect = Conf::get('secure.default_secure_page');
				}

				$this->_redirect($redirect);
			}

			$this->formMapper->addMappingError('login', 'errorusernameorpass');
			$this->form->getFormElement('username')->notMapped();
			$this->form->getFormElement('password')->notMapped();
			
		} catch (FormMapperException $e) {
			// this is normal. Keep this empty. We can do stuff here, but we don't need to for logging in
			// perhaps log the attempts 
		}

		return $this->_index();

	}

	/**
	 * Logout request. When logged out it redirects to
	 * the initial login screen
	 */
	public function logout() {
		Session::getInstance()->destroy();
		$this->_redirect('login');
	}
}