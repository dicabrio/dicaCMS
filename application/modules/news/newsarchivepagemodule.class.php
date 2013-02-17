<?php

class NewsarchivePageModule implements PageModuleController {

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
	/**
	 * @var array
	 */
	private $newsItems = array();
	/**
	 * @var News
	 */
	private $selectedNewsItem;
	/**
	 *
	 * @var string
	 */
	private $template;
	/**
	 *
	 * @var string
	 */
	private $type;
	/**
	 *
	 * @var string
	 */
	private $amount;

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
		$this->load();
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

	private function load() {

		$this->templateFile = new TemplateFile();
		
		$this->type = 'news';
		$this->template = 'newsarchive';
		$this->amount = '-1'; // all

		$this->getParam('type');
		$this->getParam('template');
		$this->getParam('amount');

		$this->templateFile = TemplateFile::findByTitle($this->template);

		$activeBlogs = array();

		if ($this->amount == '-1') {
			// get all articles
			$activeBlogs = News::findTypeActive($this->type, -1);
			$amountOfActiveBlogs = count($activeBlogs);
		} else {
			$amountToStart = 0;
			$page = intval($this->request->get('page'));

//			if ($page > 1) {
//				$amountToStart = ($page * $amountPerPage) - $amountPerPage;
//			} else {
//				$page = 1;
//			}

			$activeBlogs = News::findTypeActive($this->type, $this->amount, $amountToStart);
			$amountOfActiveBlogs = count(News::findTypeActive($this->type, $this->amount, $amountToStart));
		}

		$newsArticlesForTemplate = array();
		foreach ($activeBlogs as $newsItem) {
			$newsArticlesForTemplate[] = $this->buildNewsArray($newsItem);
		}

		$this->selectedNewsItem = new News($this->request->get('newsitem'));
		$this->newsItems = $newsArticlesForTemplate;
	}

	private function buildNewsArray(News $news = null) {

		if ($news == null) {
			return array('id' => '', 'title' => '', 'summary' => '', 'body' => '', 'publishtime' => '');
		}

		return array('id' => $news->getID(), 'title' => $news->getTitle(), 'summary' => $news->getSummary(), 'body' => $news->getBody(), 'publishtime' => $news->getPublishTime());
	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		if ($this->templateFile == null) {
			return '';
		}

		try {
			$view = new View(Conf::get('upload.dir.templates') . '/' . $this->templateFile->getFilename());
			$view->assign('wwwurl', Conf::get('general.url.www'));
			$view->assign('pagename', $this->page->getName());
			$view->assign('articles', $this->newsItems);
			$view->assign('selectedItem', $this->buildNewsArray($this->selectedNewsItem));

			return $view;
		} catch (Exception $e) {
			if (DEBUG) {
				return $e->getMessage();
			}
		}
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		
	}

}