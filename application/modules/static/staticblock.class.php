<?php

class StaticBlock extends DataRecord {

	const C_FORMAT_PATH = "%s/static_%s-%s.php";

	private $oldtplname;

	private $location;


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

		parent::addColumn('identifier', DataTypes::VARCHAR, 255, false);
		parent::addColumn('content', DataTypes::TEXT, false, false);
		parent::addColumn('created', DataTypes::DATETIME, false, false);

	}

	/**
	 * update the internal information with the correct values
	 * 
	 * @param TextLine $identifier
	 * @param DomainText $content
	 */
	public function update(RequiredTextLine $identifier, DomainText $content, $location) {

		$this->setAttr('identifier', $identifier);
		$this->setAttr('content', $content);
		$this->location = $location;
		
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

	/**
	 * get all staticblocks
	 * 
	 * @return array
	 */
	public static function find() {
		return parent::findAll(__CLASS__, parent::ALL);
	}

	/**
	 * 
	 */
	public function save() {

		parent::save();
		$format = "%s/static_%s-%s.php";
		$oldfile = sprintf($format, $this->path, $this->oldtplname, $this->getAttr('id'));

		try {
			$file = new FileManager($oldfile);
			$file->delete();
		} catch (FileNotFoundException $e) {
			// no problem if the file is not found
		}

		$source = (get_magic_quotes_gpc()) ? stripslashes($this->getAttr('source')) : $this->getAttr('source');
		$title = $this->getAttr('title');

		$newfile = sprintf($format, $this->path, $title, $this->getAttr('id'));
		file_put_contents($newfile, $source);

	}
}