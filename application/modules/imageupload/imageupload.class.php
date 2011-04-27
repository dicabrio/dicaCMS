<?php

class ImageUpload extends Upload {

	private $image;

	/**
	 *
	 * @param array $fileinfo
	 * @param int $maxWidth
	 * @param int $maxHeight
	 * @param string $allowedMimeTypes (comma seperated values)
	 * @return void
	 */
	public function __construct($fileinfo, $maxWidth=null, $maxHeight=null) {
		parent::__construct($fileinfo);

		$this->validateFileType('jpeg|jpg|png|gif');

		if (!$this->isUploaded()) {
			return ;
		}
		
		$this->image = new Image($this->getFile());

		if ($maxWidth != null || $maxHeight != null) {
			$this->validateDimensions($maxWidth, $maxHeight);
		}
	}

	private function validateDimensions($maxWidth, $maxHeight) {
		
		if ($maxWidth != null && $this->image->getWidth() > $maxWidth) {
			throw new UploadException('file-dimensions-too-big', 200);
		}
		
		if ($maxHeight != null && $this->image->getHeight() > $maxHeight) {
			throw new UploadException('file-dimensions-too-big', 200);
		}
	}
}
