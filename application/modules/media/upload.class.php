<?php


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
		UPLOAD_ERR_NO_FILE => 'no-file-uploaded',
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
		$this->validateFileType();

		$this->file = new FileManager($this->tmp_name);
		
	}

	/**
	 *
	 * @param string $newLocation
	 */
	public function moveTo($newLocation) {

		$this->file->moveTo($newLocation, $this->name);
		
	}

	/**
	 *
	 * @return FileManager
	 */
	public function getFile() {

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
	
	private function validateFileType() {
		// filetypes
		// extensions
		if (self::$allowedFileTypes === null) {
			// all are allowed
		} else if (isset(self::$allowedFileTypes[$this->type])) {
			// if it is allowed
		} else {
			// it is not allwed
			throw new InvalidArgumentException('file type is not allowed');
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