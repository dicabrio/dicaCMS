<?php

class MediaForm extends Form {

	/**
	 *
	 * @var TemplateFile
	 */
	private $mediaItem;
	
	/**
	 *
	 * @var array
	 */
	private $mediaFolders;
	
	/**
	 *
	 * @var MediaFolder
	 */
	private $currentFolder;

	/**
	 *
	 * @param Request $req
	 * @param TemplateFile $mediaItem
	 */
	public function __construct(Media $mediaItem, $mediaFolders=array(), $currentFolder = null) {

		$this->mediaItem = $mediaItem;
		$this->mediaFolders = $mediaFolders;
		$this->currentFolder = $currentFolder;
		parent::__construct(Conf::get('general.cmsurl.www').'/media/editmedia/'.$mediaItem->getID(), Request::POST, 'mediaform');

	}

	protected function defineFormElements() {

		$tplid = new Input('hidden', 'media_id', $this->mediaItem->getID());
		$this->addFormElement($tplid);

		$tplname = new Input('text', 'title', $this->mediaItem->getTitle());
		$this->addFormElement($tplname);

		$tpldescription = new TextArea('description', $this->mediaItem->getDescription());
		$this->addFormElement($tpldescription);

		$fileInput = new Input('file', 'media');
		$this->addFormElement($fileInput);
		
		
		$folderSelect = new Select('mediafolder');
		$folderSelect->addOption(0, 'Hoofdmap');
		foreach ($this->mediaFolders as $folder) {
			$folderSelect->addOption($folder->getID(), $folder->getName());
		}
		
		if ($this->currentFolder == null) {
			$folderSelect->setValue($this->mediaItem->getFolder()->getID());
			test($this->currentFolder);
		} else {
			$folderSelect->setValue($this->currentFolder->getID());
		}
		$this->addFormElement($folderSelect);

	}

}