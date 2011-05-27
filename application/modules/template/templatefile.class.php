<?php

class TemplateFile extends DataRecord implements DomainEntity {

	private $parent;

	private $path;

	private $oldtplname;

	private $module;

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
		parent::addColumn('source', DataTypes::TEXT, false, true);
		parent::addColumn('folder_id', DataTypes::INT, false, true);
		parent::addColumn('module_id', DataTypes::INT, false, true);
		parent::addColumn('created', DataTypes::DATETIME, false, true);

	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->getAttr('title');
	}

	/**
	 * @param string $sTitle
	 */
	public function setTitle($sTitle) {

		$this->oldtplname = $this->getAttr('title');
		$this->setAttr('title', $sTitle);

	}

	/**
	 * @return Module
	 */
	public function getModule() {
		if ($this->module === null) {
			$this->module = new Module($this->getAttr('module_id'));
		}

		return $this->module;
	}

	public function setModule(Module $mod) {

		if (!$mod->equals($this->module)) {
			$this->setAttr('module_id', $mod->getID());
			$this->module = $mod;
		}
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

	public function setSource(DomainText $source) {
		$this->setAttr('source', $source->getValue());
	}

	/**
	 * @return string
	 */
	public function getSource() {
		return $this->getAttr('source');
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function getFilename() {
		$title = $this->getAttr('title');
		return $title.'-'.$this->getID().'.php';
	}

	/**
	 * @return int
	 */
	public function getParent() {
		if ($this->parent == null) {
			$this->parent = new TemplateFileFolder($this->getAttr('folder_id'));
		}
		return $this->parent;
	}

	/**
	 * @param int $iParentID
	 */
	public function setParent(TemplateFileFolder $template) {

		$this->parent = $template;

		$this->setAttr('folder_id', $template->getID());
	}

	/**
	 * find all template files
	 * @return array
	 */
	public static function findAll() {
		return parent::findAll(__CLASS__, parent::ALL);
	}

	/**
	 * find template files within a given folder
	 *
	 * @param TemplateFileFolder $folder
	 * @return array
	 */
	public static function findInFolder(TemplateFileFolder $folder) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' folder_id = :parentid', array('parentid' => $folder->getID())));
	}

	/**
	 * Get all template files for corresponding modules.
	 *
	 * @param Module $module
	 * @return array
	 */
	public static function findByModule(Module $module) {

		$crit = new Criteria('module_id = :moduleid', array('moduleid' => $module->getID()));
		return parent::findAll(__CLASS__, parent::ALL, $crit);

	}

	public static function findByTitle($title) {
		$crit = new Criteria('title = :title', array('title' => $title));
		$result = parent::findAll(__CLASS__, parent::ALL, $crit);

		if (count($result) > 0) {
			return reset($result);
		}

		return new TemplateFile();
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

	public function save() {

		parent::save();
		$format = "%s/%s-%s.php";
		$oldfile = realpath(sprintf($format, $this->path, $this->oldtplname, $this->getAttr('id')));

		try {
			$file = new FileManager($oldfile);
			$file->delete();
		} catch (FileNotFoundException $e) {
			// no problem if the file is not found
		}

		$source = (get_magic_quotes_gpc()) ? stripslashes($this->getAttr('source')) : $this->getAttr('source');
		$title = $this->getAttr('title');

		$newfile = new FileManager(sprintf($format, $this->path, $title, $this->getAttr('id')), true);
		$newfile->setContents($source);

	}

	public function delete() {

		$format = "%s/%s-%s.php";
		$filepath = (sprintf($format, $this->path, $this->getAttr('title'), $this->getAttr('id')));

		try {
			$file = new FileManager($filepath);
			$file->delete();
		} catch (FileNotFoundException $e) {
			// file cannot be found. This isn't problem just delete the record
		}

		parent::delete();

	}

}

