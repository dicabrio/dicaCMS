<?php

class Page extends DataRecord {

	/**
	 * @var TemplateFile
	 */
	private $oTemplate;

	/**
	 * @var array
	 */
	private $aModules;

	/**
	 * constructor
	 *
	 * @param int $id
	 */
	public function __construct($id=null) {
		parent::__construct(__CLASS__, $id);
		if ($id == 0) {
			$this->created = date("Y-m-d H:i:s");
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#defineColumns()
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('template_id', DataTypes::INT, false, true);
		parent::addColumn('publishtime', DataTypes::DATETIME, 255, true);
		parent::addColumn('expiretime', DataTypes::DATETIME, 255, true);
		parent::addColumn('created', DataTypes::DATETIME, 255, true);
		parent::addColumn('redirect', DataTypes::VARCHAR, 255, true);
		parent::addColumn('active', DataTypes::INT, false, true);
		parent::addColumn('parent_id', DataTypes::INT, false, true);
		parent::addColumn('isfolder', DataTypes::INT, false, true);

	}

	/**
	 * get The pagename
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
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

	/**
	 * Return all PageModules that are linked to this page.
	 *
	 * @return array
	 */
	public function getModules() {
		if ($this->aModules === null) {
			$this->aModules = PageModule::getByPage($this);
		}

		return $this->aModules;
	}

	/**
	 * add a module to this page
	 *
	 * @param string $oModule
	 * @return void
	 */
	public function addModule(PageModule $oModule) {
		$this->getModules(); // init
		
		$oModule->setPage($this);
		
		if ($oModule->getID() == 0) {
			$oModule->save();
		}

		$this->aModules[$oModule->getIdentifier()] = $oModule;
	}

	/**
	 * get a module by a given identifier. It returns NULL when the given module is not found
	 *
	 * @param string $sModuleIdentifier
	 * @return PageModule
	 */
	public function getModule($sModuleIdentifier) {
		$this->getModules(); // init

		if (isset($this->aModules[$sModuleIdentifier])) {
			return $this->aModules[$sModuleIdentifier];
		}

		return null;
	}

	/**
	 * remove a certain module from the page
	 *
	 * @param string $sModuleIdentifier
	 * @return void
	 */
	public function removeModule($sModuleIdentifier) {
		$this->getModules();

		if (isset($this->aModules[$sModuleIdentifier])) {
			$this->aModules[$sModuleIdentifier]->delete();
			unset($this->aModules[$sModuleIdentifier]);
		}
	}

	/**
	 * This method will clear the internal cache. It sets the internal filled array to an empty array.
	 * When trying to load it will not load any new data. 
	 * 
	 * If you want to clear the internal cache and reload data you should give the $bReload parameter as TRUE
	 *
	 * @param boolean $bReload
	 * @return void
	 */
	public function clearCachedModules($bReload=false) {
		if ($bReload === true) {
			$this->aModules = null;
		} else {
			$this->aModules = array();
		}
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
		
		if ('0000-00-00 00:00:00' === $this->expiretime) {
			return '';
		}
		
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
	public function setName($sPagename) {
		$this->name = $sPagename;
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
//		if (!preg_match("/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2}/", $sExpireTime)) { //Y-m-d H:i:s
//			$sExpireTime = date("Y-m-d H:i:s");
//		}
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

		if (is_array($this->aModule)) {
			foreach ($this->aModules as $oModule) {
				$this->aModules->save();
			}
		}

		$this->template_id = $this->oTemplate->getID();
		parent::save();
	}

	public static function getByParent($iParentID) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' parent_id = :parentid', array('parentid' => $iParentID)));
	}
	
	public static function getByName($sPagename) {
		$aPages = parent::findAll(__CLASS__, parent::ALL, new Criteria(' name = :name', array('name' => $sPagename)));
		
		if (count($aPages) > 0) {
			return reset($aPages);
		}
		
		return null;
	}

}

class PageRecordException extends RecordException {}

