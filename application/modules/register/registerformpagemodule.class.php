<?php

class RegisterformPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var array
	 */
	private $aErrors;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 *
	 * @var Request
	 */
	private $request;

	/**
	 * @var RequiredEmail
	 */
	private $email;

	/**
	 * @var Page
	 */
	private $thnxpage;

	private $activated;

	private $allreadyactivated;

	private $isregistered;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->request = $request;
		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$registered = $this->request->get('registered');
		if ($registered == 1) {
			$this->isregistered = true;
		}

		$activationKey = $this->request->get('activate');
		if (empty($activationKey)) {
			return;
		}

		$user = User::findByActivationKey($activationKey);

		if ($user == null) {
			return;
		}

		if ($user->isActive()) {
			$this->allreadyactivated = true;
		} else {
			$user->setActive(true);
			$user->save();
			$this->activated = true;
		}


	}

	/**
	 * @return View
	 */
	public function getContents() {

		return $this->buildView($this->buildForm());

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();

	}

	private function buildForm() {

		$request = Request::getInstance();
		$mapper = new FormMapper();
		$formHandler = new RegisterformHandler($mapper, $this->page, $this->email, $this->thnxpage);

		$button = new Input('submit', 'register-'.$this->page->getName(), Lang::get('general.formsubmit'));
		$elements = array($name = new Input('text', 'name'),
				$email = new Input('text', 'email'),
				$telefoon = new Input('text', 'password'),
		);

		$form = new Form(Conf::get('general.url.www').'/'.$this->page->getName());
		foreach ($elements as $element) {
			$form->addFormElement($element->getName(), $element);
		}
		$form->addSubmitButton($button->getName(), $button, $formHandler);
		$form->listen($this->request);

		$this->aErrors = $mapper->getMappingErrors();

		return $form;
	}

	private function buildView(Form $form) {

		if ($this->isregistered) {
			return '<p>Je bent geregistreerd. Je krijgt een email om je account te activeren. Daarna kun je inloggen en bestanden down- en uploaden</p>';
		}

		if ($this->allreadyactivated) {
			return '<p>Je bent reeds geactiveerd</p>';
		}

		if ($this->activated) {
			return '<p>Je bent geactiveerd. Je kunt nu inloggen</p>';
		}

		$errors = '';
		if (count($this->aErrors) > 0) {
			$errors = '<ul class="error">';

			foreach ($this->aErrors as $error) {
				$errors .= '<li>'.Lang::get('register.'.$error).'</li>';
			}

			$errors .='</ul>';
		}


		$view = $errors.$form->begin().'
						<table class="formtable">
							<tr>
								<th><label for="name">Naam:</label>*</th>
								<td>'.$form->getFormElement('name').'</td>
							</tr>
							<tr>
								<th><label for="email">E-mail/gebruikersnaam:</label>*</th>
								<td>'.$form->getFormElement('email').'</td>
							</tr>
							<tr>
								<th><label for="password">Wachtwoord:</label></th>
								<td>'.$form->getFormElement('password').'</td>
							</tr>
							<tr>
								<th>&nbsp;</th>
								<td>'.$form->getSubmitButton('register-'.$this->page->getName()).'</td>
							</tr>
							<tr>
								<th>&nbsp;</th>
								<td>* verplichte velden</td>
							</tr>
						</table>
					'.$form->end();
		return $view;
	}
}