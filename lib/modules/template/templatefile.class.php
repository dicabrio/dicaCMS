<?php

class TemplateFile extends DataRecord {

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
		return $this->title;
	}

	/**
	 * @param string $sTitle
	 */
	public function setTitle($sTitle) {
		$this->title = $sTitle;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 *
	 * @param string $sDescription
	 */
	public function setDescription($sDescription) {
		$this->description = $sDescription;
	}

	/**
	 * get The filename of the image
	 *
	 * @return string
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * get the Path where this image is stored
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * check wether this object is a folder
	 *
	 * @return unknown
	 */
	public function isFolder() {
		if ($this->isfolder == 1) {
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
			$this->isfolder =  1;
		} else if ($bFolder == false) {
			$this->isfolder = 0;
		}
	}

	/**
	 * set the path to the image where it is stored
	 *
	 * @param string $sPath
	 */
	public function setPath($sPath) {
		$this->path = $sPath;
	}

	/**
	 * @return int
	 */
	public function getParent() {
		return $this->parent_id;
	}

	/**
	 * @param int $iParentID
	 */
	public function setParent($iParentID) {
		$this->parent_id = $iParentID;
	}

	/**
	 * set the filename of the image
	 *
	 * @param string $sFilename
	 */
	public function setFilename($sFilename) {
		$this->filename = $sFilename;
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

}

