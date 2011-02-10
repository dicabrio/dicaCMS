<?php

class LoginPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;

	/**
	 * @var TemplateFile
	 */
	private $templateFile;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var Form
	 */
	private $loginForm;

	/**
	 * @var FormMapper
	 */
	private $loginMapper;

	/**
	 * construct the text line module
	 *
	 * @param string $sIdentifier
	 * @param Page $oPage
	 * @return void
	 */
	public function __construct(PageModule $oMod, Page $page, Request $request) {

		$this->pageModule = $oMod;
		$this->page = $page;
		$this->request = $request;
		
		$this->load();

	}

	/**
	 * load the needed information
	 */
	private function load() {

		$logout = $this->request->get('logout');
		if ($logout == 1) {
			$session = Session::getInstance();
			$session->destroy();

			Util::gotoPage(Conf::get('general.url.www').'/'.$this->page->getName());
		}

		$this->loginMapper = new LoginMapper();
		$handler = new LoginHandler($this->loginMapper, $this->request, Conf::get('general.url.www').'/'.$this->page->getName());

		$this->loginForm = new LoginForm(Conf::get('general.url.www').'/'.$this->page->getName());
		$this->loginForm->addListener('login', $handler);
		$this->loginForm->listen($this->request);
		
		$this->templateFile = Relation::getSingle('pagemodule', 'templatefile', $this->pageModule);


	}

	/**
	 * @return View
	 */
	public function getContents() {

		$session = Session::getInstance();

		if ($this->templateFile === null) {
			return Lang::get('login.notabletologin');
		} 
		
		$view = new View(Conf::get('upload.dir.templates').'/'.$this->templateFile->getFilename());
		$view->assign('pagename', $this->page->getName());
		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('imagesurl', Conf::get('general.url.images'));
		$view->assign('mediaurl', Conf::get('general.url.www').Conf::get('upload.url.general'));

		$view->assign('flash', $session->get('flash'));
		$view->assign('errors', $this->loginMapper->getMappingErrors());

		$view->assign('formbegin', $this->loginForm->begin());
		$view->assign('username', $this->loginForm->getFormElement('username'));
		$view->assign('password', $this->loginForm->getFormElement('password'));
		$view->assign('button', $this->loginForm->getFormElement('login'));
		$view->assign('formend', $this->loginForm->end());

		$session->set('flash', null);

		return $view;

	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();

	}

}
