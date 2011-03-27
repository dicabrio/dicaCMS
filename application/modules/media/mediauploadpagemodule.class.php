<?php

class MediauploadPageModule implements PageModuleController {

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
	 * @var Tag
	 */
	private $selectedTag;
	/**
	 * @var Form
	 */
	private $form;

	/**
	 *
	 * @var array
	 */
	private $tags = array();

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
		$this->defineForm();
	}

	private function load() {

		$auth = Authentication::getInstance();
		$user = $auth->getUser();

		$this->tags = Tag::findAll();

		$this->selectedTag = Tag::findByName($this->request->get('tag'));

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
				'filelocation' => Conf::get('general.url.www') . '/upload/' . $file->getFilename(),
				'filename' => $file->getFilename(),
				'tags' => array()
			);
		}
	}

	private function defineForm() {

		$this->form = new Form(Conf::get('general.url.www').'/'.$this->page->getName(), Request::POST, 'uploadMediaForm');

		$this->fileInput = new Input('file', 'media');
		$this->form->addFormElement($this->fileInput);

		// define description (alt text) field
		$this->titleInput = new Input("text", "title");
		$this->form->addFormElement($this->titleInput);

		$this->descriptionInput = new TextArea("description");
		$this->form->addFormElement($this->descriptionInput);

		foreach ($this->tags as $tag) {
			$tagCheckbox = new CheckboxInput('tags[]', $tag->getName());
			$this->form->addFormElement($tagCheckbox);
		}

		$this->actionButton = new ActionButton("Opslaan");
		$this->form->addSubmitButton($this->actionButton, new MediaTagSaveHandler(new FormMapper(), $this->page));

		$this->form->listen($this->request);
	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

//		$view = new View(Conf::get('general.dir.templates') . '/media/mediatagsoverview.php');
		$view = new View(Conf::get('general.dir.templates') . '/media/mediauploadpagemodule.php');
		$view->assign('form', $this->form);
		$view->assign('wwwurl', Conf::get('general.url.www'));
		$view->assign('pageurl', $this->page->getName());
		$view->assign('mediaItems', $this->mediaItems);
		$view->assign('selectedTag', $this->selectedTag);
		$view->assign('tags', $this->tags);
		$view->assign('errors', array());

		return $view;
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {
		return $this->pageModule->getIdentifier();
	}

}