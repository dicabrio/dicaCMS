<?php

class ImageuploadCmsModule implements CmsModuleController {

	/**
	 * @var PageModule
	 */
	private $oPageModule;

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
	private $defaultImage;

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

		$this->oPageModule = $oMod;
		$this->form = $form;

		$this->load();
		$this->defineForm();

	}

	private function load() {

		$mediaItem = Relation::getSingle('pagemodule', 'media', $this->oPageModule);
		if ($mediaItem === null) {
			$mediaItem = new Media();
			Relation::remove('pagemodule', 'media', $this->oPageModule);
		}
		$this->mediaItem = $mediaItem;
		$this->defaultImage = Setting::getByName('defaultimage')->getValue();
	}

	private function defineForm() {

		// define upload field
		$this->fileInput = new Input('file', $this->oPageModule->getIdentifier());
		$this->fileInputName = $this->fileInput->getName();
		$this->form->addFormElement($this->fileInputName, $this->fileInput);

		// define description (alt text) field
		$this->titleInput = new Input("text", $this->oPageModule->getIdentifier()."title", $this->mediaItem->getTitle());
		$this->titleInputName = $this->titleInput->getName();
		$this->form->addFormElement($this->titleInputName, $this->titleInput);

		$this->descriptionInput = new TextArea($this->oPageModule->getIdentifier()."description", $this->mediaItem->getDescription());
		$this->descriptionInputName = $this->descriptionInput->getName();
		$this->form->addFormElement($this->descriptionInputName, $this->descriptionInput);

	}

	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping($this->fileInputName, "ImageUpload");
		$this->mapper->addFormElementToDomainEntityMapping($this->titleInputName, "TextLine");
		$this->mapper->addFormElementToDomainEntityMapping($this->descriptionInputName, "DomainText");

	}

	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {
		
		$oView = new View('imageupload/imageuploadform.php');
		$oView->form = $this->form;

		$filename = false;
		$alttext = false;

		if ($this->mediaItem !== null) {
			try {
				$alttext = $this->mediaItem->getTitle();
				$filename = $this->mediaItem->getFile()->getFilename();
			} catch (FileNotFoundException $e) {

			}
		}

		$oView->filename = $filename;
		$oView->alttext = $alttext;
		$oView->defaultimage = $this->getDefaultImage();
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		

		return $oView;
	}

	/**
	 * Handle the data. Saving/deleting/updating
	 * @return void
	 */
	public function handleData() {

		// when overhere... there shouldn't be any errors from the form
		$sModIdentifier = $this->oPageModule->getIdentifier();

		$title = $this->mapper->getModel($sModIdentifier."title");
		$description = $this->mapper->getModel($sModIdentifier."description");
		$upload = $this->mapper->getModel($sModIdentifier);

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();

		$new = false;
		if ($this->mediaItem->getID() == 0) {
			$new = true;
		}
		
		$this->mediaItem->update($title, $description, $file);
		$this->mediaItem->save();

		if ($new) {
			Relation::add('pagemodule', 'media', $this->oPageModule, $this->mediaItem);
		}
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}

	/**
	 *
	 * @return string
	 */
	protected function getDefaultImage() {

		return $this->defaultImage;
		
	}
}