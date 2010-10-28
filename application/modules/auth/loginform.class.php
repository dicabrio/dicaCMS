<?php
/**
 * LoginForm
 *
 * Form that will handle the login stuff
 */
class LoginForm extends Form {

	/**
	 * @param Request $req
	 */
	public function __construct($action) {
		
		parent::__construct($action, Request::POST, 'loginform');

	}

	/**
	 * define form elements for login
	 */
	protected function defineFormElements() {

		$oUsername = new Input('text', 'username');
		$this->addFormElement($oUsername->getName(), $oUsername);

		$oPassword = new Input('password', 'password');
		$this->addFormElement($oPassword->getName(), $oPassword);

		$action = new ActionButton(Lang::get('login.button'));
		$this->addFormElement('login', $action);
		
	}
}