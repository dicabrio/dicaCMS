<?php
/**
 *
 */
class MediaFolder extends Folder {

	/**
	 *
	 * @param int $id 
	 */
	public function __construct($id=null) {

		parent::__construct('Media', $id);
		
	}

	/**
	 *
	 * @param string $folderName
	 * @return MediaFolder
	 */
	public static function findByName($folderName) {
		return parent::findByName(__CLASS__, $folderName);
	}
	
	/**
	 *
	 * @return array
	 */
	public static function findAll() {
		return parent::findAll(__CLASS__);
	}

}



class MediaFolderRecordException extends RecordException {}

