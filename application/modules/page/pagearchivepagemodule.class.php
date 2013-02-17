<?php

class PagearchivePageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var Page
	 */
	private $page;
	/**
	 * @var Request
	 */
	private $request;

	private $type;

	private $amount;

	private $template;

	private $custompagemodule;

	private $order;

	/**
	 *
	 * @param PageModule $module
	 * @param Page $oPage
	 * @param Request $request
	 * @return void
	 */
	public function __construct(PageModule $module, Page $page, Request $request) {

		$this->pageModule = $module;
		$this->page = $page;
		$this->request = $request;

		$this->type = 'all';
		$this->amount = '-1';
		$this->template = 'pagearchive';
		$this->custompagemodule = 'subject,summary';
		$this->order = 'ASC';
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

	private function buildPageArray(Page $blog) {

		$pageModule = $blog->getModule('subject');
		$pageTextSubject = PageText::getByPageModule($pageModule);

		$pageModule = $blog->getModule('summary');
		$pageTextSummary = PageText::getByPageModule($pageModule);

		return array(
			'title' => $blog->getTitle(),
			'name' => $blog->getName(),
			'subject' => $pageTextSubject->getContent(),
			'summary' => $pageTextSummary->getContent());

	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$this->getParam('type');
		$this->getParam('amount');
		$this->getParam('template');
		$this->getParam('order');
		$this->getParam('custompagemodule');

		if ($this->amount == '-1') {
			// get all articles
			$activeBlogs = Page::findActive(-1, null, $this->type);
//			test($activeBlogs);
			$amountOfActiveBlogs = count($activeBlogs);
//			test(count($amountOfActiveBlogs));
			
		} else {
			$amountToStart = 0;
			$page = intval($this->request->get('page'));

			if ($page > 1) {
				$amountToStart = ($page * $this->amount) - $this->amount;
			} else {
				$page = 1;
			}

			$activeBlogs = Page::findActive($this->amount, $amountToStart, $this->type);
			$amountOfActiveBlogs = count(Page::findActive(-1, null, $this->type));
		}

		$blogArticlesForTemplate = array();
		foreach ($activeBlogs as $page) {
			$blogArticlesForTemplate[] = $this->buildPageArray($page);
		}

		try {

			$tplFile = TemplateFile::findByTitle($this->template);
			$view = new View(Conf::get('upload.dir.templates').'/'.$tplFile->getFilename());
			$view->assign('wwwurl', Conf::get('general.url.www'));
			$view->assign('pagename', $this->page->getName());
			$view->assign('articles', $blogArticlesForTemplate);
			
			return $view;
		} catch (Exception $e) {
			return '';
		}
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		return '';
	}

}