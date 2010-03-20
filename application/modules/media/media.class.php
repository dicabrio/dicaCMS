<?php

class Media extends DataRecord implements DomainEntity {

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
	 * @param RequiredTextLine $title
	 * @param string $description
	 * @param FileManager $file
	 */
	public function update(RequiredTextLine $title, $description, FileManager $file) {

		test($file->getMimeType());

		$this->setAttr('title', $title);
		$this->setAttr('description', $description);
		$this->setAttr('filename', $file->getFilename());
		$this->setAttr('extension', $file->getExtension());
		$this->setAttr('mimetype', $file->getMimeType());
		$this->setAttr('folder_id', 0);

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

