<?php

class ImageuploadCmsModule implements CmsModuleController {

	/**
	 * max input
	 */
	const MAX_LENGTH = 255;

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
	 * construct the imageupload module
	 *
	 * @param PageModule $oMod
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, FormMapper $mapper, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;
		$this->form = $form;
		$this->mapper = $mapper;
		$this->cmsController = $oCmsController;

		$this->load();
		$this->defineForm();

	}

	private function load() {

		$mediaItem = Relation::getSingle('pagemodule', 'media', $this->oPageModule);
		if ($mediaItem === null) {
			$mediaItem = new Media();
		}
		$this->mediaItem = $mediaItem;
	}

	private function defineForm() {

		// define upload field
		$fileInput = new Input('file', $this->oPageModule->getIdentifier());
		$fileInputName = $fileInput->getName();
		$this->form->addFormElement($fileInputName, $fileInput);
		$this->mapper->addFormElementToDomainEntityMapping($fileInputName, "Upload");


		// define description (alt text) field
		$descriptionInput = new Input("text", $this->oPageModule->getIdentifier()."description", $this->mediaItem->getTitle());
		$descriptionInputName = $descriptionInput->getName();
		$this->form->addFormElement($descriptionInputName, $descriptionInput);
		$this->mapper->addFormElementToDomainEntityMapping($descriptionInputName, "TextLine");

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

		return $oView;
	}

	/**
	 * Handle the data. Saving/deleting/updating
	 * @return void
	 */
	public function handleData() {

		// when overhere... there shouldn't be any errors from the form
		$sModIdentifier = $this->oPageModule->getIdentifier();
		$description = $this->mapper->getModel($sModIdentifier."description");
		$upload = $this->mapper->getModel($sModIdentifier);

		try {

			$upload->validateFileType(Conf::get('imageupload.allowedfiles'));

		} catch (Exception $e) {

			$this->mapper->addMappingError($sModIdentifier, $e->getMessage());
			$this->form->getFormElementByName($sModIdentifier)->notMapped();
			throw new FormMapperException($e->getMessage(), 100, $e);
		}

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();

		$new = false;
		if ($this->mediaItem->getID() == 0) {
			$new = true;
		}
		
		$this->mediaItem->update($description, "", $file);
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
}