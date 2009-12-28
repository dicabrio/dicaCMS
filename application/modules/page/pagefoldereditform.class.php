<?php

class PageFolderEditForm extends Form {
	
	/**
	 * @var PageFolder
	 */
	private $pagefolder;

	/**
	 * @param Request $oReq
	 * @param array $aElements
	 */
	public function __construct(Request $oReq, PageFolder $pagefolder) {
		$this->pagefolder = $pagefolder;

		parent::__construct($oReq, Conf::get('general.url.www').'/page/editfolder/'.$pagefolder->getID(), Request::POST, 'pagefolderform');
	}

	/**
	 * 
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'folder_id');
		$elPageID->setValue($this->pagefolder->getID());
		parent::addFormElement($elPageID->getName(), $elPageID);

		$elPagename = new Input('text', 'name');
		$elPagename->setValue($this->pagefolder->getName());
		parent::addFormElement($elPagename->getName(), $elPagename);

		$elDescription = new TextArea('description');
		$elDescription->setValue($this->pagefolder->getDescription());
		parent::addFormElement($elDescription->getName(), $elDescription);
		
	}
}