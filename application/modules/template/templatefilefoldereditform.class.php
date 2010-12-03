<?php

class TemplateFileFolderEditForm extends Form {
	
	/**
	 * @var Folder
	 */
	private $templatefolder;

	/**
	 * @param Request $oReq
	 * @param array $aElements
	 */
	public function __construct(TemplateFileFolder $pagefolder) {

		$this->templatefolder = $pagefolder;
		parent::__construct(Conf::get('general.url.www').'/template/editfolder/'.$pagefolder->getID(), Request::POST, 'templatefolderform');
		
	}

	/**
	 * 
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'folder_id');
		$elPageID->setValue($this->templatefolder->getID());
		parent::addFormElement($elPageID->getName(), $elPageID);

		$elPagename = new Input('text', 'name');
		$elPagename->setValue($this->templatefolder->getName());
		parent::addFormElement($elPagename->getName(), $elPagename);

		$elDescription = new TextArea('description');
		$elDescription->setValue($this->templatefolder->getDescription());
		parent::addFormElement($elDescription->getName(), $elDescription);
		
	}
}