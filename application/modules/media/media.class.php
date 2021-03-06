<?php

class Media extends DataRecord implements DomainEntity {

	/**
	 *
	 * @var FileManager
	 */
	private $file;

	/**
	 * @var User
	 */
	private $owner;
	
	/**
	 * @var MediaFolder
	 */
	private $folder;

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);

		if ($id == 0) {
			$this->setAttr('created', date('Y-m-d H:i:s'));
		}

	}

	/**
	 * @return void
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('title', DataTypes::VARCHAR, 255, true);
		parent::addColumn('description', DataTypes::TEXT, 500, true);
		parent::addColumn('filename', DataTypes::VARCHAR, 255, true);
		parent::addColumn('extension', DataTypes::VARCHAR, 255, true);
		parent::addColumn('mimetype', DataTypes::VARCHAR, 255, true);
		parent::addColumn('folder_id', DataTypes::INT, false, true);
		parent::addColumn('created', DataTypes::DATETIME, false, true);
		parent::addColumn('location', DataTypes::VARCHAR, 255, true);
		parent::addColumn('user_id', DataTypes::INT, false, true);

	}

	/**
	 * get the title
	 *
	 * @return string
	 */
	public function getTitle() {

		return $this->getAttr('title');

	}

	/**
	 *
	 * @return get the description
	 */
	public function getDescription() {

		return $this->getAttr('description');

	}

	/**
	 *
	 */
	public function getOwner() {

		if ($this->owner === null) {
			$this->owner = new User($this->getAttr('user_id'));
		}

		return $this->owner;

	}

	public function setOwner(User $owner) {

		if ($this->getID() == 0) {
			$this->owner = $owner;
			$this->setAttr('user_id', $owner->getID());
		}

	}
	
	public function setFolder(MediaFolder $folder) {
		$this->folder = $folder;
		$this->setAttr('folder_id', $folder->getID());
	}
	
	/**
	 *
	 * @return MediaFolder
	 */
	public function getFolder() {
		
		if ($this->folder == null) {
			$this->folder = new MediaFolder($this->getAttr('folder_id'));
		}
		
		return $this->folder;
	}

	/**
	 * @return boolean
	 */
	public function valid() {

		return true;

	}

	/**
	 *
	 * @return FileManager
	 */
	public function getFile() {

		if ($this->file === null) {
			$this->file = new FileManager($this->getAttr('location').'/'.$this->getAttr('filename'));
		}

		return $this->file;

	}

	/**
	 *
	 * @param RequiredTextLine $title
	 * @param string $description
	 * @param FileManager $file
	 */
	public function update(TextLine $title, $description, FileManager $file=null) {

		try {
			if ($file instanceof FileManager) {
				$this->getFile()->delete();
			}
		} catch (FileNotFoundException $e) {

		}

		if ($file !== null) {
			$this->file = $file;

			$this->setAttr('filename', $file->getFilename());
			$this->setAttr('location', $file->getPath());
			$this->setAttr('extension', $file->getExtension());
			$this->setAttr('mimetype', $file->getMimeType());
		}

		$this->setAttr('title', $title);
		$this->setAttr('description', $description);
		$this->setAttr('folder_id', 0);

	}

	public function delete() {

		try {

			$file = $this->getFile();
			$file->delete();

		} catch (FileNotFoundException $e) {
			// no problem just delete it
		}

		parent::delete();
		
	}

	/**
	 * find all media items
	 *
	 * @return array
	 */
	public static function find() {

		return parent::findAll(__CLASS__, parent::ALL);
	}
	
	public static function findWithTags() {

		$sql = "	SELECT DISTINCT		m.* 
					FROM				`media` AS m 
					
						LEFT JOIN		`media_tag` as mt 
							ON			m.id = mt.media_id 
							
					WHERE				mt.media_id IS NOT NULL";
		
		return parent::findBySql(__CLASS__, $sql);
	}
	
	/**
	 * Get every page that is placed in the given folder. When nothing is there this method will return an empty array
	 *
	 * @param PageFolder $folder
	 * @return array
	 */
	public static function findInFolder(Folder $folder) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' folder_id = :parentid ', array('parentid' => $folder->getID())));
	}

}

