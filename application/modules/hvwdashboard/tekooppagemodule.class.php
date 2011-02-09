<?php

class TekoopPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
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
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->request = $request;
		$this->pageModule = $oMod;
		$this->page = $page;
		$this->load();
	}

	/**
	 * load the needed information
	 */
	private function load() {

	}

	/**
	 * @return View
	 */
	public function getContents() {

		$view = new View(Conf::get('general.dir.templates') . '/hvwdashboard/hvwdashboard-addhuis.php');

		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('imagesurl', Conf::get('general.url.images'));
		$view->assign('jsurl', Conf::get('general.url.js'));
		$view->assign('cssurl', Conf::get('general.url.css'));
//		$oView->form = $this->form;
		$view->identifier = $this->pageModule->getIdentifier();
		$view->pagename = $this->page->getName();

//		$this->checkActivePage($view);
//		$view->dashboardpage = $this->getDashboardPage();

		$auth = Authentication::getInstance();
		$view->user = $auth->getUser();

		return $view;

//		return $this->buildView($this->buildForm());
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}

//	private function buildForm() {
//
//		$request = Request::getInstance();
//		$mapper = new FormMapper();
//		$formHandler = new ContactformHandler($mapper, $this->page, $this->email, $this->thnxpage);
//
//		$button = new Input('submit', 'contactform-'.$this->page->getName(), Lang::get('general.formsubmit'));
//		$elements = array($name = new Input('text', 'naam'),
//				$email = new Input('text', 'email'),
//				$telefoon = new Input('text', 'telefoon'),
//				$bericht = new TextArea('bericht'),
//		);
//
//		$form = new Form(Conf::get('general.cmsurl.www').'/'.$this->page->getName().'.html');
//		foreach ($elements as $element) {
//			$form->addFormElement($element->getName(), $element);
//		}
//		$form->addSubmitButton($button->getName(), $button, $formHandler);
//		$form->listen($this->request);
//
//		$this->aErrors = $mapper->getMappingErrors();
//
//		return $form;
//	}
//	private function buildView(Form $form) {
//
//		$errors = '';
//		if (count($this->aErrors) > 0) {
//			$errors = '<ul class="error">';
//
//			foreach ($this->aErrors as $error) {
//				$errors .= '<li>'.Lang::get('contact.'.$error).'</li>';
//			}
//
//			$errors .='</ul>';
//		}
//
//
//		$view = $errors.$form->begin().'
//						<table class="formtable">
//							<tr>
//								<th><label for="name">Naam:</label>*</th>
//								<td>'.$form->getFormElement('naam').'</td>
//							</tr>
//							<tr>
//								<th><label for="email">E-mail:</label>*</th>
//								<td>'.$form->getFormElement('email').'</td>
//							</tr>
//							<tr>
//								<th><label for="phone">Telefoon:</label></th>
//								<td>'.$form->getFormElement('telefoon').'</td>
//							</tr>
//							<tr>
//								<th><label for="comment">Opmerking:</label>*</th>
//								<td>'.$form->getFormElement('bericht')->addAttribute('rows', 7)->addAttribute('cols', 45).'</td>
//							</tr>
//							<tr>
//								<th>&nbsp;</th>
//								<td>'.$form->getSubmitButton('contactform-'.$this->page->getName()).'</td>
//							</tr>
//							<tr>
//								<th>&nbsp;</th>
//								<td>* verplichte velden</td>
//							</tr>
//						</table>
//					'.$form->end();
//		return $view;
//	}
}