<?php

class Page extends DataRecord
{
	/**
	 * @var TemplateFile
	 */
	private $oTemplate;

	/**
	 * constructor
	 *
	 * @param int $id
	 */
	public function __construct($id=null)
	{
		parent::__construct(__CLASS__, $id);
		if ($id == 0) {
			$this->created = date("Y-m-d H:i:s");
		}

	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#defineColumns()
	 */
	protected function defineColumns()
	{
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('pagename', DataTypes::VARCHAR, 255, true);
		parent::addColumn('template_id', DataTypes::INT, false, true);
		parent::addColumn('publishtime', DataTypes::DATETIME, 255, true);
		parent::addColumn('expiretime', DataTypes::DATETIME, 255, true);
		parent::addColumn('created', DataTypes::DATETIME, 255, true);
		parent::addColumn('redirect', DataTypes::VARCHAR, 255, true);
		parent::addColumn('active', DataTypes::INT, false, true);

		parent::addColumn('parent_id', DataTypes::INT, false, true);
		parent::addColumn('folder', DataTypes::INT, false, true);
	}

	/**
	 * get The pagename
	 *
	 * @return string
	 */
	public function getPagename() {
		return $this->pagename;
	}

	/**
	 * get the Path where this image is stored
	 *
	 * @return TemplateFile
	 */
	public function getTemplate() {

		if ($this->oTemplate === null) {
			$this->oTemplate = new TemplateFile($this->template_id);
		}

		return $this->oTemplate;
	}
	
	public function getModules() {
		
	}

	/**
	 * @return string
	 */
	public function getPublishTime() {
		return $this->publishtime;
	}

	/**
	 * @return string
	 */
	public function getExpireTime() {
		return $this->expiretime;
	}

	/**
	 * @return string
	 */
	public function getRedirect() {
		return $this->redirect;
	}

	/**
	 * @return string
	 */
	public function getCreated() {
		return $this->created;
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
	 * @param $bActive
	 * @return void
	 */
	public function setActive($bActive) {

		if ($bActive == true) {
			$this->active =  1;
		} else if ($bActive == false) {
			$this->active = 0;
		}
	}

	/**
	 * @param string $sPagename
	 */
	public function setPagename($sPagename) {
		$this->pagename = $sPagename;
	}

	/**
	 * @param TemplateFile $oTemplate
	 */
	public function setTemplate(TemplateFile $oTemplate) {
		$this->oTemplate = $oTemplate;
	}

	/**
	 * when no correct datetimestring is given it will use the current time
	 * datetime string should have the following pattern: yyyy-mm-dd hh:mm:ss
	 *
	 * @param $sPublishTime
	 * @return void
	 */
	public function setPublishTime($sPublishTime=null) {
		if (!preg_match("/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/", $sPublishTime)) {
			$sPublishTime = date("Y-m-d H:i:s");
		}
		$this->publishtime = $sPublishTime;
	}

	/**
	 * when no correct datetimestring is given it will use the current time
	 * datetime string should have the following pattern: yyyy-mm-dd hh:mm:ss
	 *
	 * @param $sExpireTime
	 * @return void
	 */
	public function setExpireTime($sExpireTime=null) {
		if (!preg_match("/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/", $sExpireTime)) { //Y-m-d H:i:s
			$sExpireTime = date("Y-m-d H:i:s");
		}
		$this->expiretime = $sExpireTime;
	}

	/**
	 * @param $sRedirect
	 * @return void
	 */
	public function setRedirect($sRedirect) {
		$this->redirect = $sRedirect;
	}

	/**
	 * @return int
	 */
	public function getParent() {
		return $this->parent_id;
	}

	/**
	 * check wether this object is a folder
	 *
	 * @return unknown
	 */
	public function isFolder() {
		if ($this->folder == 1) {
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
			$this->folder =  1;
		} else if ($bFolder == false) {
			$this->folder = 0;
		}
	}

	/**
	 * @param int $iParentID
	 */
	public function setParent($iParentID) {
		$this->parent_id = $iParentID;
	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#save()
	 */
	public function save() {
		
		if (!($this->oTemplate instanceof TemplateFile) || $this->oTemplate->getID() == 0) {
			throw new PageRecordException("please provide a template for this page: ".$this->id);
		}

		$this->template_id = $this->oTemplate->getID();
		parent::save();
	}
	
	public static function getByParent($iParentID) {
		return parent::findAll(__CLASS__, parent::ALL, new QueryPart(' parent_id = :parentid', array('parentid' => $iParentID)));
	}

}

class PageRecordException extends RecordException {}

?>