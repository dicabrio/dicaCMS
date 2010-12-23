<?php
/**
 *
 */
class PageFolder extends Folder {

	/**
	 *
	 * @param int $id 
	 */
	public function __construct($id=null) {

		parent::__construct('Page', $id);
		
	}

	public static function findByName($folderName) {
		return parent::findByName(__CLASS__, $folderName);
	}

}



class PageFolderRecordException extends RecordException {}

