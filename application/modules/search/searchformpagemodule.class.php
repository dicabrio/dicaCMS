<?php

class SearchformPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var Page
	 */
	private $redirectpage;
	/**
	 * @var Page
	 */
	private $page;
	/**
	 *
	 * @var Form
	 */
	private $form;
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

		$this->oPageModule = $oMod;
		$this->page = $page;
		$this->request = $request;

		$this->load();
	}

	/**
	 * load the needed information
	 */
	private function load() {

		$pageText = PageText::getByPageModule($this->oPageModule);
		$this->redirectpage = new Page($pageText->getContent());


		$zoekfield = new Input('text', 'zoekterm', $this->request->request('zoekterm'));
		$zoekfield->addAttribute('id', 'zoekterm');

		$button = new ActionButton('Zoek');
		$button->addAttribute('id', 'zoekbtn');

		$this->form = new Form(Conf::get('general.url.www').'/'.$this->redirectpage->getName(), Request::GET, 'zoekformulier');
		$this->form->addFormElement($zoekfield);
		$this->form->addFormElement($button);
	}

	/**
	 * @return View
	 */
	public function getContents() {


		return $this->form->begin().'
						<fieldset>
							<label for="zoekterm" class="default">Adres, postcode, plaats, snelcode</label>
							'.$this->form->getFormElement('zoekterm').'
							'.$this->form->getFormElement('action').'
						</fieldset>
					'.$this->form->end();

//		$view = new View(Conf::get('upload.dir.templates') . '/' . $this->templateFile->getFilename());
//		$view->assign('wwwurl', Conf::get('general.url.www'));
//		$view->assign('imagesurl', Conf::get('general.url.images'));
//		$view->assign('mediaurl', Conf::get('general.url.www') . Conf::get('upload.url.general'));
//		$view->assign('results', $this->results);
//		$view->assign('pagename', $this->page->getName());
//
//		return $view;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}

}