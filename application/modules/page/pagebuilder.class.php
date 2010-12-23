<?php


class PageBuilder {

	/**
	 * @var Page $page 
	 */
	private $page;

	/**
	 * @var array
	 */
	private $pageModuleLabels;

	/**
	 * 
	 * @param Page $page
	 */
	public function __construct(Page $page) {

		$this->page = $page;

	}

	/**
	 * call to build the page from the template. It will extract labels from the template the page is given.
	 * These will be added as pagemodules
	 *
	 * @return Page $page
	 */
	public function buildPageFromTemplate() {

		$this->extractPageModuleLabelsFromTemplate();

		$existingPageModules = $this->page->getModules();
		$this->pageModuleControllers = array();
		foreach ($this->pageModuleLabels as $moduleLabel) {

			$pageModule = $this->page->getModule($moduleLabel['id']);
			if ($pageModule === null) {
				$pageModule = $this->createNewPageModuleAndAddToPage($moduleLabel);
			} else {
				$pageModule->setType($moduleLabel['module']);
			}

			unset($existingPageModules[$moduleLabel['id']]);
		}

		foreach ($existingPageModules as $key => $pagemodule) {
			$pagemodule->delete();
			unset($existingPageModules[$key]);
		}

		return $this->page;
	}

	/**
	 * 
	 */
	private function extractPageModuleLabelsFromTemplate() {

		$pageTemplate = $this->page->getTemplate();
		$viewParser = new ViewParser($pageTemplate);
		$this->pageModuleLabels = $viewParser->getLabels();

	}

	/**
	 * 
	 * @param string $moduleLabel
	 */
	private function createNewPageModuleAndAddToPage($moduleLabel) {

		$pageModule = new PageModule();
		$pageModule->setType($moduleLabel['module']);
		$pageModule->setIdentifier($moduleLabel['id']);

		$this->page->addModule($pageModule);
		
	}
}