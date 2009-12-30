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

}



class PageFolderRecordException extends RecordException {}

