<?php

class TagsPageModule implements PageModuleController {

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
	private $tags;
	/**
	 * @var Tag
	 */
	private $selectedTag;

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

	private function load() {

		$this->selectedTag = Tag::findByName($this->request->get('tag'));
		$this->tags = Tag::findAll();
	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$view = new View(Conf::get('general.dir.templates') . '/tag/tagsoverview.php');
		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('pageurl', $this->page->getName());
		$view->assign('tags', $this->tags);
		$view->assign('selectedTag', $this->selectedTag);
		return $view;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		
	}

}