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
	
		$this->validateError($fileInfo['error']);
	
	
		test($fileInfo);
	}
	
	/**
	 *
	 * @param int $sizeInKB
	 */
	public static function setMaxUploadSize($sizeInKB) {
	
		self::$maxUploadSize = $sizeInKB;
	
	}
	
	public static function setUploadFileTypes($allowedFileTypes) {
		
		self::$allowedFileTypes = $allowedFileTypes;
		
	}
	
	
	private function validateError($errorNumber) {
	
		$message = false;
		
		if (isset(self::$errorMessages[$errorNumber])) {
			$message = self::$errorMessages[$errorNumber];
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