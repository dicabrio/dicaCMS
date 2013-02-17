<?php

/**
 * @package Pagemoduletemplate 
 * @author Robert Cabri <robert@dicabrio.com>
 * 
 * This is a template for a page module
 * Just copy it, rename it to your own module you would like to
 * have. 
 * 
 * This class is used for the frontend
 * 
 * usage in your template:
 * 
 * [[<modulename>:<identifier> <parameter name>="<parameter value>"]]
 * 
 * in this case:
 * [[pagemoduletemplate:my_identifier label="foo"]]
 * 
 * 
 * 
 */
class PagelistPageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
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
	 * As the above example states this $label will have the value of foo. 
	 * 
	 * @var string
	 */
	private $label;
	/**
	 *
	 * @var string
	 */
	private $template;

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
		
		$this->custompagemodule = 'product_naam,product_prijs,product_afbeelding_klein,product_inleiding';

		$this->getParam('label');
		$this->getParam('template');
		$this->getParam('custompagemodule');
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
	 * @return View
	 */
	public function getContents() {

		try {

			$selectedPages = PageText::getByPageModule($this->pageModule);
			$selectedPageIDS = $selectedPages->getContent();
			$selectedPagesOrder = explode(',', $selectedPageIDS);
			$pages = Page::findIn($selectedPagesOrder);


			$pagesInfoForTemplate = array();
			foreach ($pages as $page) {
				
				$key = array_search($page->getID(), $selectedPagesOrder);
				$pagesInfoForTemplate[$key] = $this->buildPageArray($page);
			}
			
			ksort($pagesInfoForTemplate);

			$tplFile = TemplateFile::findByTitle($this->template);
			$view = new View(Conf::get('upload.dir.templates') . '/' . $tplFile->getFilename());
			$view->assign('wwwurl', Conf::get('general.url.www'));
			$view->assign('pagename', $this->page->getName());
			$view->assign('articles', $pagesInfoForTemplate);

			return $view;
		} catch (Exception $e) {
			if (DEBUG) {
				return $e->getMessage();
			}
			return '';
		}

		return "hello world i'v added a label : " . $this->label;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->pageModule->getIdentifier();
	}

	/**
	 *
	 * @param string $name 
	 */
	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

}