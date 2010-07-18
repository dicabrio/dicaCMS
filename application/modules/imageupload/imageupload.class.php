<?php

class ImageUpload extends Upload {

	private $image;

	public function __construct($fileinfo) {
		parent::__construct($fileinfo);

		// validate imageupload specifics
		$maxSize = Conf::get('imageupload.allowedsize.filesize');
		$maxWidth = Conf::get('imageupload.allowedsize.width');
		$maxHeight = Conf::get('imageupload.allowedsize.height');

		$allowedMimeTypes = Conf::get('imageupload.allowedmimetypes');

		$this->validateFileType($allowedMimeTypes);
		$this->validateFileSize($maxSize);

		if (!$this->isUploaded()) {
			return ;
		}

		$this->image = new Image($this->getFile());

		$this->validateDimensions($maxWidth, $maxHeight);

	}

	private function validateDimensions($maxWidth, $maxHeight) {

		if ($this->image->getWidth() > $maxWidth || $this->image->getHeight() > $maxHeight) {
			throw new UploadException('file-dimensions-too-big', 200);
		}

	}
}
