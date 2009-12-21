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
	protected function __construct($id=null) {
		parent::__construct(__CLASS__, $id);
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
	 *
	 * @param string $pagename
	 * @param TemplateFile $template
	 * @param Date $publishtime
	 * @param Date $expiretime
	 * @param string $keywords
	 * @param string $description
	 */
	public static function create($pagename, TemplateFile $template, Date $publishtime=null, Date $expiretime=null, $keywords="", $description="") {
		$page = new Page();
		$page->setAttr('name', $pagename);
		$page->setAttr('template_id', $template->getID());
		$page->setAttr('publishtime', $publishtime);
		$page->setAttr('expiretime', $expiretime);
		$page->setAttr('keywords', $keywords);
		$page->setAttr('description', $description);
		$page->setAttr('created', date("Y-m-d H:i:s"));
	}

	/**
	 *
	 * @param String $pagename
	 * @param View $template
	 * @param Date $publishtime
	 * @param Date $expiretime
	 * @param String $keywords
	 * @param String $description
	 */
	public function update($pagename, TemplateFile $template, Date $publishtime=null, Date $expiretime=null, $keywords="", $description="") {
		$this->setAttr('name', $pagename);
		$this->setAttr('template_id', $template->getID());
		$this->setAttr('publishtime', $pagename);
		$this->setAttr('expiretime', $pagename);
		$this->setAttr('keywords', $keywords);
		$this->setAttr('description', $description);
	}


	/**
	 *
	 * @param int $id
	 * @return page
	 */
	public static function findByID($id) {
		$page = new Page($id);
		if ($id == 0) {
			throw new RecordException('Cannot find a page with id 0');
		}
		
		return $page;
	}

	/**
	 * @param string $pagename
	 * @return Page
	 */
	public static function findByName($pagename) {
		$aPages = parent::findAll(__CLASS__, parent::ALL, new Criteria(' name = :name', array('name' => $pagename)));

		if (count($aPages) > 0) {
			return reset($aPages);
		}

		return null;
	}

	public static function findInFolder(PageFolder $folder) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' parent_id = :parentid', array('parentid' => $folder->getID())));
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
	 * @return string
	 */
	public function getPublishTime() {
		return new Date($this->publishtime);
	}

	/**
	 * @return string
	 */
	public function getExpireTime() {
		
		if ('0000-00-00 00:00:00' === $this->expiretime) {
			return '';
		}
		
		return new Date($this->expiretime);
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
	 * @return Page
	 */
	public function getParent() {
		
		$page = new Page($this->getAttr('parent_id'));

		return $page;
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
	 * (non-PHPdoc)
	 * @see data/DataRecord#save()
	 */
	public function save() {

		if ($this->getAttr('template_id') == 0) {
			throw new PageFolderRecordException("please provide a template for this page: ".$this->id);
		}

		if (is_array($this->aModule)) {
			foreach ($this->aModules as $oModule) {
				$this->aModules->save();
			}
		}

		parent::save();
	}
}

class PageFolderRecordException extends RecordException {}

