<?php
/**
 * Handle the action login
 */
class LoginHandler implements FormHandler {

	const C_AUTH_SESSIONNAME = 'CMS';

	/**
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 * @var Request
	 */
	private $req;

	/**
	 *
	 * @param FormMapper $mapper
	 */
	public function __construct(FormMapper $mapper, Request $req) {
		$this->mapper = $mapper;
		$this->req = $req;
	}

	/**
	 * @param Form $form
	 */
	public function handleForm(Form $form) {

		try {
			$this->mapper->constructModelsFromForm($form);

			$oAuth = Authentication::getInstance(self::C_AUTH_SESSIONNAME);
			if ($oAuth->login($this->mapper->getModel('username'), $this->mapper->getModel('password'))) {
				$oSession = Session::getInstance();
				// your are logged in go to next page
				$sRedirect = $oSession->get('redirect');

				if (empty($sRedirect)) {
					$sRedirect = 'dashboard';
				} 

				$this->req->redirect(Conf::get('general.url.www').'/'.$sRedirect);
			}

			$this->mapper->addMappingError('login', 'errorusernameorpass');
			$form->getFormElement('username')->notMapped();
			$form->getFormElement('password')->notMapped();
		} catch (FormMapperException $e) {
			//
		}
	}
}