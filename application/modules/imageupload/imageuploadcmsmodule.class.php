<?php

class ImageuploadCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var Form
	 */
	private $form;
	/**
	 * @var FormMapper
	 */
	private $mapper;
	/**
	 * @var Media
	 */
	private $mediaItem;
	/**
	 * @var string
	 */
	private $defaultimage;
	/**
	 * @var FormElement
	 */
	private $fileInputName;
	/**
	 * @var FormElement
	 */
	private $titleInputName;
	/**
	 *
	 * @var FormElement
	 */
	private $descriptionInputName;
	/**
	 *
	 * @var string
	 */
	private $label;
	/**
	 *
	 * @var int
	 */
	private $maxwidth;
	/**
	 *
	 * @var int
	 */
	private $maxheight;

	/**
	 * construct the imageupload module
	 *
	 * @param PageModule $oMod
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->pageModule = $oMod;
		$this->form = $form;

		$this->load();
		$this->defineForm();
	}

	private function load() {

		$this->maxwidth = Conf::get('imageupload.allowedsize.width');
		$this->maxheight = Conf::get('imageupload.allowedsize.height');

		$this->label = 'Imageupload : ' . $this->pageModule->getIdentifier();
		$this->defaultimage = Setting::getByName('defaultimage')->getValue();

		$this->getParam('label');
		$this->getParam('maxwidth');
		$this->getParam('maxheight');
		$this->getParam('defaultimage');

		$mediaItem = Relation::getSingle('pagemodule', 'media', $this->pageModule);
		if ($mediaItem === null) {
			$mediaItem = new Media();
			Relation::remove('pagemodule', 'media', $this->pageModule);
		}
		$this->mediaItem = $mediaItem;
	}

	private function defineForm() {

		// define upload field
		$this->fileInput = new Input('file', $this->pageModule->getIdentifier());
		$this->fileInputName = $this->fileInput->getName();
		$this->form->addFormElement($this->fileInput);

		// define description (alt text) field
		$this->titleInput = new Input("text", $this->pageModule->getIdentifier() . "title", $this->mediaItem->getTitle());
		$this->titleInputName = $this->titleInput->getName();
		$this->form->addFormElement($this->titleInput);

		$this->descriptionInput = new TextArea($this->pageModule->getIdentifier() . "description", $this->mediaItem->getDescription());
		$this->descriptionInputName = $this->descriptionInput->getName();
		$this->form->addFormElement($this->descriptionInput);
	}

	public function addFormMapping(FormMapper $mapper) {

		//Conf::get('imageupload.allowedmimetypes');

		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping($this->fileInputName, "ImageUpload:" . $this->maxwidth . "," . $this->maxheight . "");
		$this->mapper->addFormElementToDomainEntityMapping($this->titleInputName, "TextLine");
		$this->mapper->addFormElementToDomainEntityMapping($this->descriptionInputName, "DomainText");
	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$view = new View(Conf::get('general.dir.templates') . '/imageupload/imageuploadform.php');
		$view->assign('form', $this->form);

		$filename = false;
		$alttext = false;

		if ($this->mediaItem !== null) {
			try {
				$alttext = $this->mediaItem->getTitle();
				$filename = $this->mediaItem->getFile()->getFilename();
			} catch (FileNotFoundException $e) {
				
			}
		}

		$view->assign('filename', $filename);
		$view->assign('alttext', $alttext);
		$view->assign('defaultimage', $this->getDefaultImage());
		$view->assign('identifier', $this->pageModule->getIdentifier());
		$view->assign('label', $this->label);

		return $view;
	}

	/**
	 * Handle the data. Saving/deleting/updating
	 * @return void
	 */
	public function handleData() {

		// when overhere... there shouldn't be any errors from the form
		$sModIdentifier = $this->pageModule->getIdentifier();

		$title = $this->mapper->getModel($sModIdentifier . "title");
		$description = $this->mapper->getModel($sModIdentifier . "description");
		$upload = $this->mapper->getModel($sModIdentifier);

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();

		if ($file !== null) {

			Relation::remove('pagemodule', 'media', $this->pageModule);

			$title = $file->getFilename();
			$media = new Media();
			$media->update(new TextLine($title), $description, $file);
			$media->save();

			Relation::add('pagemodule', 'media', $this->pageModule, $this->mediaItem);
		}
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
	 * @return string
	 */
	protected function getDefaultImage() {

		return $this->defaultimage;
	}

	private function getParam($name) {
		$value = $this->pageModule->getParameter($name);
		if ($value !== null) {
			$this->{$name} = $value;
		}
	}

}