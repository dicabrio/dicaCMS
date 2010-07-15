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

		$this->defineForm();

	}

	private function defineForm() {

		// define upload field
		$fileInput = new Input('file', $this->oPageModule->getIdentifier());
		$fileInputName = $fileInput->getName();
		$this->form->addFormElement($fileInputName, $fileInput);
		$this->mapper->addFormElementToDomainEntityMapping($fileInputName, "Upload");

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);

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