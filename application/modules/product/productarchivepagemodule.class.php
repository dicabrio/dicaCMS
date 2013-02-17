<?php

class ProductarchivePageModule implements PageModuleController {

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

		$this->type = 'product';
		$this->template = 'product_list';
		$this->amount = '-1'; // all

		$this->getParam('type');
		$this->getParam('template');
		$this->getParam('amount');

		$this->templateFile = TemplateFile::findByTitle($this->template);

		$activeBlogs = array();

		if ($this->amount == '-1') {
			// get all articles
			$activeBlogs = Product::findTypeActive($this->type, -1);
			$amountOfActiveBlogs = count($activeBlogs);
		} else {
			$amountToStart = 0;
			$page = intval($this->request->get('page'));

//			if ($page > 1) {
//				$amountToStart = ($page * $amountPerPage) - $amountPerPage;
//			} else {
//				$page = 1;
//			}

			$activeBlogs = Product::findTypeActive($this->type, $this->amount, $amountToStart);
			$amountOfActiveBlogs = count(Product::findTypeActive($this->type, $this->amount, $amountToStart));
		}

		$newsArticlesForTemplate = array();
		foreach ($activeBlogs as $newsItem) {
			$newsArticlesForTemplate[] = $this->buildNewsArray($newsItem);
		}

		$this->selectedNewsItem = new Product($this->request->get('newsitem'));
		$this->newsItems = $newsArticlesForTemplate;
	}

	private function buildNewsArray(Product $product = null) {

		if ($product == null) {
			return array(
				'id' => '',
				'title' => '',
				'summary' => '',
				'body' => '',
				'publishtime' => '',
				'price' => '',
				'image' => '',
				'detail_images' => '');
		}

		try {
			$image = $product->getImage();
			$detailImage = $product->getDetailImage();

			$imageFilename = Conf::get('general.url.www').Conf::get('upload.url.general').'/'.$image->getFile()->getFilename();
			$detailImageFilename = Conf::get('general.url.www').Conf::get('upload.url.general').'/'.$detailImage->getFile()->getFilename();
		} catch (Exception $e) {
			$imageFilename = '';
			$detailImageFilename = '';
		}

		return array(
			'id' => $product->getID(),
			'title' => $product->getTitle(),
			'summary' => $product->getSummary(),
			'body' => $product->getBody(),
			'publishtime' => $product->getPublishTime(),
			'price' => $product->getPrice(),
			'image' => $imageFilename,
			'detail_images' => $detailImageFilename);
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