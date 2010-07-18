<?php

class UploadException extends Exception {}

class Upload implements DomainEntity {

	private $name;

	private $type;

	private $tmp_name;

	private $error;

	private $size;

	/**
	 *
	 * @var FileManager
	 */
	private $file;

	private static $errorMessages = array(
			/*UPLOAD_ERR_NO_FILE => 'no-file-uploaded',*/
			UPLOAD_ERR_PARTIAL => 'partial-file-uploaded',
			UPLOAD_ERR_FORM_SIZE => 'max-file-size-uplooaded',
			UPLOAD_ERR_INI_SIZE => 'max-file-size-system-uploaded',
			UPLOAD_ERR_NO_TMP_DIR => 'no-tmp-dir',
			UPLOAD_ERR_CANT_WRITE => 'tmpdir-not-writable',
			UPLOAD_ERR_EXTENSION => 'extension-stopped-uploading',

	);

	private static $maxUploadSize;

	private static $allowedFileTypes;

	/**
	 * given parameter should be the $_FILES
	 *
	 * @param array $fileInfo
	 */
	public function __construct($fileInfo) {

		$this->name = $fileInfo['name'];
		$this->type = $fileInfo['type'];
		$this->tmp_name = $fileInfo['tmp_name'];
		$this->error = $fileInfo['error'];
		$this->size = $fileInfo['size'];

		$this->validateError();

		try {
			$this->file = new FileManager($this->tmp_name);
		} catch (FileNotFoundException $e) {
			// leave it for now. No worries
		}

	}

	public function moveTo($newLocation) {

		if ($this->error != UPLOAD_ERR_NO_FILE) {
			$this->file->moveTo($newLocation, $this->name);
		}

	}

	/**
	 *
	 * @return FileManager
	 */
	public function getFile() {

		if ($this->error == UPLOAD_ERR_NO_FILE) {
			return null;
		}

		return $this->file;

	}

	/**
	 *
	 * @param int $sizeInBytes
	 */
	public static function setMaxUploadSize($sizeInBytes) {

		self::$maxUploadSize = $sizeInKB;

	}

	public static function setUploadFileTypes($allowedFileTypes) {

		self::$allowedFileTypes = $allowedFileTypes;

	}

	protected function isUploaded() {
		return ($this->error != UPLOAD_ERR_NO_FILE);
	}

	protected function validateFileType($allowedTypes=null) {

		if (!$this->isUploaded()) {
			return ;
		}

		if ($allowedTypes === null) {
			return true;
		} else if (isset($allowedTypes[$this->type])) {
			return true;
		} else {
			throw new InvalidArgumentException('file-type-not-allowed');
		}

	}

	protected function validateFileSize($filesize) {

		if (!$this->isUploaded()) {
			return ;
		}
		if ($this->size > $filesize) {
			throw new FileException('uploaded-file-too-big', 100);
		}

	}

	private function validateError() {

		$message = false;
		if (isset(self::$errorMessages[$this->error])) {
			$message = self::$errorMessages[$this->error];
		}

		if ($message !== false) {
			throw new InvalidArgumentException($message, 10);
		}
	}

	/**
	 *
	 */
	public function __toString() {
		return 'Upload file: '.$this->name;
	}

	public function equals($object) {

		if ($object === null) {
			return null;
		}

		if (!is_a($object, get_class($this))) {
			return false;
		}

		return true;
	}
}