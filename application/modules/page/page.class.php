<?php

class Page extends DataRecord implements DomainEntity {

	/**
	 * @var TemplateFile
	 */
	private $oTemplate;

	/**
	 * @var array
	 */
	private $aModules;

	/**
	 *
	 * @var array
	 */
	private $aRemoveModules = array();

	/**
	 * constructor
	 *
	 * @param int $id
	 */
	public function __construct($id=null) {
		parent::__construct(__CLASS__, $id);

		if ($id == 0) {
			$this->setAttr('created', date("Y-m-d H:i:s"));
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#defineColumns()
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('title', DataTypes::VARCHAR, 255, true);
		parent::addColumn('template_id', DataTypes::INT, false, true);
		parent::addColumn('publishtime', DataTypes::DATETIME, 255, true);
		parent::addColumn('expiretime', DataTypes::DATETIME, 255, true);
		parent::addColumn('created', DataTypes::DATETIME, 255, true);
		parent::addColumn('redirect', DataTypes::VARCHAR, 255, true);
		parent::addColumn('keywords', DataTypes::TEXT, false, true);
		parent::addColumn('description', DataTypes::TEXT, false, true);
		parent::addColumn('active', DataTypes::INT, false, true);
		parent::addColumn('folder_id', DataTypes::INT, false, true);

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
	public function update($pagename, TemplateFile $template, Date $publishtime=null, Date $expiretime=null, $title="", $keywords="", $description="") {

		if ($publishtime == '') {
			$publishtime = new Date("now");
		}

		$this->setAttr('name', $pagename);
		$this->setAttr('template_id', $template->getID());
		$this->setAttr('publishtime', $publishtime->getValue());
		$this->setAttr('expiretime', (string)$expiretime);
		$this->setAttr('title', $title);
		$this->setAttr('keywords', $keywords);
		$this->setAttr('description', $description);

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
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' folder_id = :parentid ', array('parentid' => $folder->getID())));
	}

	public static function findActive() {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' active = :active ', array('active' => 1)));
	}


	/**
	 * get The pagename
	 *
	 * @return string
	 */
	public function getName() {
		return $this->getAttr('name');
	}

	/**
	 * get The pagename
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->getAttr('title');
	}

	/**
	 * get the Path where this image is stored
	 *
	 * @return TemplateFile
	 */
	public function getTemplate() {

		if ($this->oTemplate === null) {
			$this->oTemplate = new TemplateFile($this->getAttr('template_id'));
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

		if (isset($this->aModules[$oModule->getIdentifier()])) {
			$oldModule = $this->aModules[$oModule->getIdentifier()];
			if ($oldModule !== $oModule->getType()) {
				// the current module is from another type. Flag the old module to be deleted
				$this->aRemoveModules[] = $oldModule;
			}
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
		return new Date($this->getAttr('publishtime'));
	}

	/**
	 * @return string
	 */
	public function getExpireTime() {
		
		if ('0000-00-00 00:00:00' === $this->getAttr('expiretime')) {
			return '';
		}
		
		return new Date($this->getAttr('expiretime'));
	}

	/**
	 * @return string
	 */
	public function getRedirect() {
		return $this->getAttr('redirect');
	}

	/**
	 * @return string
	 */
	public function getCreated() {
		return $this->getAttr('created');
	}

	/**
	 * Checks wether this Image is active
	 *
	 * @return bool
	 */
	public function isActive() {
		if ($this->getAttr('active') == 1) {
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
			$this->setAttr('active', 1);
		} else if ($bActive == false) {
			$this->setAttr('active', 0);
		}
	}

	/**
	 * @return PageFolder
	 */
	public function getParent() {
		
		$page = new PageFolder($this->getAttr('folder_id'));

		return $page;
	}

	public function getDescription() {
		return $this->getAttr('description');
	}

	public function getKeywords() {
		return $this->getAttr('keywords');
	}

	public function setParent(PageFolder $folder) {
		$this->setAttr('folder_id', $folder->getID());
	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#save()
	 */
	public function save() {

		if ($this->getAttr('template_id') == 0) {
			throw new PageRecordException("error-template");
		}

		parent::save();

		if (is_array($this->aModules)) {
			foreach ($this->aModules as $oModule) {
				$oModule->save();
			}
		}

		foreach ($this->aRemoveModules as $module) {
			$module->delete();
		}
		
	}

	public function delete() {

		foreach ($this->getModules() as $module) {
			$module->delete();
		}

		parent::delete();

	}
}

class PageRecordException extends RecordException {}

