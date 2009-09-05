<?php

class Image extends DataRecord
{
	public function __construct($id=null)
	{
		parent::__construct(__CLASS__, $id);
	}

	protected function defineColumns()
	{
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('filename', DataTypes::VARCHAR, 255, true);
		parent::addColumn('path', DataTypes::VARCHAR, 255, true);
		parent::addColumn('active', DataTypes::INT, false, true);
	}

	public static function findAll()
	{
		return parent::findAll(__CLASS__, parent::ALL);
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
	 * Checks wether this Image is active
	 *
	 * @return bool
	 */
	public function isActive() {
		if ($this->active == 1) {
			return true;
		}

		return false;
	}

	/**
	 * Set the image active or not
	 *
	 * @param bool $bActive
	 */
	public function setActive($bActive) {

		if ($bActive == true) {
			$this->active =  1;
		} else if ($bActive == false) {
			$this->active = 0;
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
	 * set the filename of the image
	 *
	 * @param string $sFilename
	 */
	public function setFilename($sFilename) {
		$this->filename = $sFilename;
	}

}


?>