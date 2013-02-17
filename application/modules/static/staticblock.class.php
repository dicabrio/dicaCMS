<?php

class StaticBlock extends DataRecord implements DomainEntity {

	/**
	 * constant for location of the file
	 */
	const C_FORMAT_PATH = "%s/static_%s-%s.php";

	/**
	 *
	 * @var string
	 */
	private $oldtplname;

	/**
	 *
	 * @param int $id
	 */
	public function __construct($id =null) {

		parent::__construct(__CLASS__, $id);
		if ($id == 0) {
			$this->setAttr('created', date('Y-m-d H:i:s'));
		}

	}

	/**
	 * define columns
	 */
	public function defineColumns() {

		parent::addColumn('name', DataTypes::VARCHAR, 255, false);
		parent::addColumn('identifier', DataTypes::VARCHAR, 255, false);
		parent::addColumn('content', DataTypes::TEXT, false, false);
		parent::addColumn('path', DataTypes::TEXT, false, false);
		parent::addColumn('created', DataTypes::DATETIME, false, false);

	}

	/**
	 * update the internal information with the correct values
	 * 
	 * @param TextLine $identifier
	 * @param DomainText $content
	 * @param string $path
	 */
	public function update(RequiredTextLine $name, TemplateTitle $identifier, DomainText $content, $path) {

		// keep old tplname if
		$this->oldtplname = $this->getAttr('identifier');

		$this->setAttr('name', $name);
		$this->setAttr('identifier', $identifier);
		$this->setAttr('content', $content);
		$this->setAttr('path', $path);
		
	}

	public function getName() {
		return $this->getAttr('name');
	}

	/**
	 * the identifier of this static block
	 * @return string
	 */
	public function getIdentifier() {

		return $this->getAttr('identifier');

	}

	/**
	 * get the content of the static block
	 * 
	 * @return string
	 */
	public function getContent() {

		return $this->getAttr('content');
		
	}

	public function getView() {

		$staticblockFile = sprintf(self::C_FORMAT_PATH, '', $this->getAttr('identifier'), $this->getAttr('id'));
		return new View(Conf::get('upload.dir.templates').$staticblockFile);

	}

	/**
	 * get all staticblocks
	 * 
	 * @return array
	 */
	public static function find() {
		return parent::findAll(__CLASS__, parent::ALL);
	}

	public static function findByIdentifier(PageModule $mod) {
		return parent::findAll(__CLASS__, parent::ALL, new Criteria("identifier = :id", array('id' => $mod->getIdentifier())));
	}

	/**
	 * 
	 */
	public function save() {

		parent::save();

		$this->removeFile($this->getAttr('path'), $this->oldtplname, $this->getAttr('id'));

		$source = (get_magic_quotes_gpc()) ? stripslashes($this->getAttr('content')) : $this->getAttr('content');

		$newfile = sprintf(self::C_FORMAT_PATH, $this->getAttr('path'), $this->getAttr('identifier'), $this->getAttr('id'));
		file_put_contents($newfile, $source);

	}
	
	private function removeFile($path, $filename, $id) {
		
		$fileToDelete = sprintf(self::C_FORMAT_PATH, $path, $filename, $id);

		try {
			$file = new FileManager($fileToDelete);
			$file->delete();
		} catch (FileNotFoundException $e) {
			// no problem if the file is not found
		}
		
	}

	public function delete() {

		$this->removeFile($this->getAttr('path'), $this->getAttr('identifier'), $this->getAttr('id'));
		parent::delete();

	}
}