<?php

class MediaFolderEditForm extends Form {
	
	/**
	 * @var PageFolder
	 */
	private $mediafolder;

	/**
	 * @param Request $oReq
	 * @param array $aElements
	 */
	public function __construct(MediaFolder $mediafolder) {
		$this->mediafolder = $mediafolder;

		parent::__construct(Conf::get('general.cmsurl.www').'/media/editfolder/'.$mediafolder->getID(), Request::POST, 'mediafolderform');
	}

	/**
	 * 
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'folder_id');
		$elPageID->setValue($this->mediafolder->getID());
		parent::addFormElement($elPageID);

		$elPagename = new Input('text', 'name');
		$elPagename->setValue($this->mediafolder->getName());
		parent::addFormElement($elPagename);

		$elDescription = new TextArea('description');
		$elDescription->setValue($this->mediafolder->getDescription());
		parent::addFormElement($elDescription);
		
	}
}