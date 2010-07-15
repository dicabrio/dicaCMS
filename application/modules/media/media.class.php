<?php

class Media extends DataRecord implements DomainEntity {

	/**
	 *
	 * @var FileManager
	 */
	private $file;

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
	 * @return boolean
	 */
	public function valid() {

		return true;

	}

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

}

