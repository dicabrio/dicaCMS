<?php

class MediatagsoverviewPageModule implements PageModuleController {

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
	private $mediaItems;
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

		$auth = Authentication::getInstance();
		$user = $auth->getUser();

		$this->selectedTag = Tag::findByName($this->request->get('tag'));
		$this->tags = Tag::findAll();

		if ($this->selectedTag instanceof Tag) {
			$mediaItems = $this->selectedTag->getMedia();
		} else {
			$mediaItems = Media::find();
		}

		$this->mediaItems = array();
		foreach ($mediaItems as $mediaItem) {
			$file = $mediaItem->getFile();
			$this->mediaItems[] = array(
				'title' => $mediaItem->getTitle(),
				'editable' => $user->equals($mediaItem->getOwner()),
				'description' => $mediaItem->getDescription(),
				'filelocation' => Conf::get('general.url.www').'/upload/'.$file->getFilename(),
				'filename' => $file->getFilename(),
				'tags' => array()
			);
		}

	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$view = new View(Conf::get('general.dir.templates') . '/media/mediatagsoverview.php');
		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('pageurl', $this->page->getName());
		$view->assign('mediaItems', $this->mediaItems);
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