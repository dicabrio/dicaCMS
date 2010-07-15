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
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var array
	 */
	private $aErrors;

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
	 * construct the text line module
	 *
	 * @param PageModule $oMod
	 * @param Form $form
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, FormMapper $mapper, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;
		$this->form = $form;
		$this->mapper = $mapper;

		$this->load();
		$this->defineForm();

	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
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
		$descriptionInput = new Input("text", $this->oPageModule->getIdentifier()."description", $this->oTextContent->getContent());
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

		if ($this->mediaItem !== null) {
			$oView->filename = $this->mediaItem->getFile()->getFilename();
			$oView->alttext = $this->mediaItem->getTitle();
		}

		return $oView;
	}

	/* (non-PHPdoc)
	 * @see modules/Module#validate()
	 * TODO make UT8 compliant
	*/
	public function validate($mData) {
		return true;
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
		$upload->validateFileType(Conf::get('imageupload.allowedfiles'));

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();


//		if ($this->mediaItem->getID() == 0 && $file === null) {
//			throw new FileNotFoundException('no-file-uploaded');
//		}
		$new = false;
		if ($this->mediaItem->getID() == 0) {
			$new = true;
		}
		$this->mediaItem->update($description, "", $file);
		$this->mediaItem->save();

		if ($new) {
			Relation::add('pagemodule', 'media', $this->oPageModule, $this->mediaItem);
		}

		$this->oTextContent->setContent((string)$description->getValue()); // cast object to string
		$this->oTextContent->setPageModule($this->oPageModule);
		$this->oTextContent->save();

	}

	/**
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->aErrors;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}