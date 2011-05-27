<?php

class PagerelatedPageModule implements PageModuleController {

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
	 * @var PageText
	 */
	private $textContent;

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
		$this->custompagemodule = 'product_naam,product_prijs,product_afbeelding_klein,product_inleiding';
		$this->order = 'ASC';
		$this->label = 'Related Pages';
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

	private function buildPageArray(Page $page) {

		$allowedPageTextModules = array('textline', 'textblock', 'htmltextblock');
		$additionalModules = explode(',', $this->custompagemodule);
		$resultPageInformation = array('title' => $page->getTitle(), 'name' => $page->getName());

		foreach ($additionalModules as $module) {
			$pageModule = $page->getModule($module);
			$type = $pageModule->getType();
			if (in_array($type, $allowedPageTextModules)) {
				$text = PageText::getByPageModule($pageModule);
				$resultPageInformation[$module] = $text->getContent();
			} else if ($type == 'imageupload') {

				$media = Relation::getSingle('pagemodule', 'media', $pageModule);
				$filename = '';
				try {
					if ($media != null) {
						$filename = Conf::get('general.url.www') . Conf::get('upload.url.general') . '/' . $media->getFile()->getFilename();
					}
				} catch (Exception $e) {
				}

				$resultPageInformation[$module] = $filename;
			}
		}

		return $resultPageInformation;
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
		$this->getParam('label');
//		$this->getParam('custompagemodule');

		$this->textContent = PageText::getByPageModule($this->pageModule);
		$relatedPages = explode(',', $this->textContent->getContent());
		$activePages = Page::findIn($relatedPages);
		$pagesForTemplate = array();
		foreach ($activePages as $page) {
			$pagesForTemplate[] = $this->buildPageArray($page);
		}

		try {

			$tplFile = TemplateFile::findByTitle($this->template);
			$view = new View(Conf::get('upload.dir.templates') . '/' . $tplFile->getFilename());
			$view->assign('wwwurl', Conf::get('general.url.www'));
			$view->assign('pagename', $this->page->getName());
			$view->assign('articles', $pagesForTemplate);

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