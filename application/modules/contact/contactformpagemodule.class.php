<?php

class ContactformPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

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

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page) {

		$this->request = Request::getInstance();
		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);

	}

	/**
	 * @return View
	 */
	public function getContents() {

		$formshizzle = explode(',', $this->oTextContent->getContent());

		try {

			// Check if the values are correct. If no email is set or not a valid page id
			// show them no contact form
			$this->email = new RequiredEmail($formshizzle[0]);
			if ($formshizzle[1] == 0) {
				throw new InvalidArgumentException('not valid', 1);
			}
			$this->thnxpage = $formshizzle[1];

		} catch (Exception $e) {
			return '';
		}

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
		$formHandler = new ContactformHandler($mapper, $this->page, $this->email, $this->thnxpage);

		$button = new Input('submit', 'contactform-'.$this->page->getName(), Lang::get('general.formsubmit'));
		$elements = array($name = new Input('text', 'naam'),
				$email = new Input('text', 'email'),
				$telefoon = new Input('text', 'telefoon'),
				$bericht = new TextArea('bericht'),
		);

		$form = new Form($request, Conf::get('general.url.www').'/'.$this->page->getName().'.html');
		foreach ($elements as $element) {
			$form->addFormElement($element->getName(), $element);
		}
		$form->addSubmitButton($button->getName(), $button, $formHandler);
		$form->listen();

		$this->aErrors = $mapper->getMappingErrors();

		return $form;
	}

	private function buildView(Form $form) {

		$errors = '';
		if (count($this->aErrors) > 0) {
			$errors = '<ul class="error">';

			foreach ($this->aErrors as $error) {
				$errors .= '<li>'.Lang::get('contact.'.$error).'</li>';
			}

			$errors .='</ul>';
		}


		$view = $errors.$form->begin().'
						<table class="formtable">
							<tr>
								<th><label for="name">Naam:</label>*</th>
								<td>'.$form->getFormElement('naam').'</td>
							</tr>
							<tr>
								<th><label for="email">E-mail:</label>*</th>
								<td>'.$form->getFormElement('email').'</td>
							</tr>
							<tr>
								<th><label for="phone">Telefoon:</label></th>
								<td>'.$form->getFormElement('telefoon').'</td>
							</tr>
							<tr>
								<th><label for="comment">Opmerking:</label>*</th>
								<td>'.$form->getFormElement('bericht')->addAttribute('rows', 7)->addAttribute('cols', 45).'</td>
							</tr>
							<tr>
								<th>&nbsp;</th>
								<td>'.$form->getSubmitButton('contactform-'.$this->page->getName()).'</td>
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