<?php

class TemplateFile extends DataRecord implements DomainEntity {

	private $parent;

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {
		parent::__construct(__CLASS__, $id);

		if ($id == 0) {
			$this->created = date('Y-m-d H:i:s');
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
		parent::addColumn('path', DataTypes::VARCHAR, 255, true);
		parent::addColumn('isfolder', DataTypes::INT, false, true);
		parent::addColumn('parent_id', DataTypes::INT, false, true);
		parent::addColumn('created', DataTypes::DATETIME, false, true);
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->getAttr('title');
//		return $this->getAttr('title');
	}

	/**
	 * @param string $sTitle
	 */
	public function setTitle($sTitle) {
		$this->setAttr('title', $sTitle);
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->getAttr('description');
	}

	/**
	 *
	 * @param string $sDescription
	 */
	public function setDescription($sDescription) {
		$this->setAttr('description', $sDescription);
	}

	/**
	 * get The filename of the image
	 *
	 * @return string
	 */
	public function getFilename() {
		return $this->getAttr('filename');
	}

	/**
	 * get the Path where this image is stored
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->getAttr('path');
	}

	/**
	 *
	 * @return string
	 */
	public function getFullPath() {
		return $this->getAttr('path').FileManager::SEP.$this->getAttr('filename');
	}

	/**
	 * check wether this object is a folder
	 *
	 * @return unknown
	 */
	public function isFolder() {
		if ($this->getAttr('isfolder') == 1) {
			return true;
		}

		return false;
	}

	/**
	 * Set the image active or not
	 *
	 * @param bool $bActive
	 */
	public function setFolder($bFolder) {

		if ($bFolder == true) {
			$this->setAttr('isfolder', 1);
		} else if ($bFolder == false) {
			$this->setAttr('isfolder', 0);
		}
	}

	/**
	 * set the path to the image where it is stored
	 *
	 * @param string $sPath
	 */
	public function setPath($sPath) {
		$this->setAttr('path', $sPath);
	}

	/**
	 * @return int
	 */
	public function getParent() {
		if ($this->parent == null) {
			$this->parent = new TemplateFile($this->getAttr('parent_id'));
		}
		return $this->parent;
	}

	/**
	 * @param int $iParentID
	 */
	public function setParent(TemplateFile $template) {
		
		$this->parent = $template;

		$this->setAttr('parent_id', $template->getID());
	}

	/**
	 * set the filename of the image
	 *
	 * @param string $sFilename
	 */
	public function setFilename($sFilename) {
		$this->setAttr('filename', $sFilename);
	}

	public static function getByParent($iParentID) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' parent_id = :parentid', array('parentid' => $iParentID)));
	}

	public static function getAll() {
		return parent::findAll(__CLASS__, parent::ALL);
	}

	public static function getFiles() {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' isfolder = :folder', array('folder' => 0)));
	}

	public function __toString() {
		return "jemoeder";
	}

	public function equals($object) {
		if (get_class($this) != get_class($object)) {
			return false;
		}

		if ($this->getID() != $object->getID()) {
			return false;
		}

		return true;
	}

}

