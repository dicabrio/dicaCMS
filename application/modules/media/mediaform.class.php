<?php

class MediaForm extends Form {

	/**
	 *
	 * @var TemplateFile
	 */
	private $mediaItem;

	/**
	 *
	 * @param Request $req
	 * @param TemplateFile $mediaItem
	 */
	public function __construct(Media $mediaItem) {

		$this->mediaItem = $mediaItem;
		parent::__construct(Conf::get('general.url.www').'/media/editmedia/'.$mediaItem->getID(), Request::POST, 'mediaform');

	}

	protected function defineFormElements() {

		$tplid = new Input('hidden', 'media_id', $this->mediaItem->getID());
		$this->addFormElement($tplid->getName(), $tplid);

		$tplname = new Input('text', 'title', $this->mediaItem->getTitle());
		$this->addFormElement($tplname->getName(), $tplname);

		$tpldescription = new TextArea('description', $this->mediaItem->getDescription());
		$this->addFormElement($tpldescription->getName(), $tpldescription);

		$fileInput = new Input('file', 'media');
		$this->addFormElement($fileInput->getName(), $fileInput);

	}

}