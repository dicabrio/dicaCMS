<?php
/**
 * LoginForm
 *
 * Form that will handle the login stuff
 */
class LoginForm extends Form {

	/**
	 * @var Request
	 */
	private $req;

	/**
	 * @var FormMapper
	 */
	private $formmapper;

	/**
	 * @param Request $req
	 */
	public function __construct(Request $req) {
		$this->req = $req;
		parent::__construct($req, Conf::get('general.url.www').'/login/', Request::POST, 'loginform');

	}

	/**
	 * define form elements for login
	 */
	protected function defineFormElements() {

		$oUsername = new Input('text', 'username');
		$this->addFormElement($oUsername->getName(), $oUsername);

		$oPassword = new Input('password', 'password');
		$this->addFormElement($oPassword->getName(), $oPassword);

		$this->formmapper = new LoginMapper($this);

		$action = new ActionButton(Lang::get('login.button'));
		$this->addSubmitButton('login', $action, new LoginHandler($this->formmapper, $this->req));
		
	}

	/**
	 * @return FormMapper
	 */
	public function getMapper() {
		return $this->formmapper;
	}
}