<?php

class TemplateFile extends DataRecord implements DomainEntity {

	private $parent;

	private $path;

	private $oldtplname;

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
		$this->setAttr('source', $source);
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

	public static function findInFolder(TemplateFileFolder $folder) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria(' folder_id = :parentid', array('parentid' => $folder->getID())));
	}

	public static function getFiles() {
		return parent::findAll(__CLASS__, parent::ALL);
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
		$oldfile = sprintf($format, $this->path, $this->oldtplname, $this->getAttr('id'));

		try {
			$file = new FileManager($oldfile);
			$file->delete();
		} catch (FileNotFoundException $e) {
			// no problem if the file is not found
		}

		$source = $this->getAttr('source');
		$title = $this->getAttr('title');

		$newfile = sprintf($format, $this->path, $title, $this->getAttr('id'));
		file_put_contents($newfile, $source);

	}

	public function delete() {

		$format = "%s/%s-%s.php";
		$filepath = sprintf($format, $this->path, $this->getAttr('title'), $this->getAttr('id'));

		try {
			$file = new FileManager($filepath);
			$file->delete();
		} catch (FileNotFoundException $e) {
			// file cannot be found. This isn't problem just delete the record
		}

		parent::delete();

	}

}

