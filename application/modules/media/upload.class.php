<?php


class Upload implements DomainEntity {

	private $name;
	
	private $type;
	
	private $tmp_name;
	
	private $error;
	
	private $size;
	
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


	public function __construct($fileInfo) {
	
		$this->name = $fileInfo['name'];
		$this->type = $fileInfo['type'];
		$this->tmp_name = $fileInfo['tmp_name'];
		$this->error = $fileInfo['error'];
		$this->size = $fileInfo['size'];
		
		test($fileInfo);
		$this->validateError();
		$this->validateFileType();
	
	
		
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
		
		self::$allowedFileTypes
		
		throw new InvalidArgumentException('just-for-fun');
		
	}
	
	private function validateError() {
	
		$message = false;
		
		if (isset(self::$errorMessages[$this->error])) {
			$message = self::$errorMessages[$this->error];
		}
		
		if ($message !== false) {
			throw new InvalidArgumentException($message);
		}
	}

	/**
	 *
	 */
	public function __toString() {
		return 'Upload file: ';
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