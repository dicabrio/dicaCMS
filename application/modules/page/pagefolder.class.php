<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
interface IFolder {

	/**
	 * @return int
	 */
	public function getID();

	/**
	 * @return title
	 */
	public function getName();

	/**
	 * @return IFolder
	 */
	public function getParent();

	/**
	 * @return boolean
	 */
	public function hasParent();

}
/**
 * Description of PHPClass
 *
 * @author robertcabri
 */
class PageFolder extends DataRecord implements IFolder {

	private $parent;

	private $pages;

	private $folders;

	/**
	 * constructor
	 *
	 * @param int $id
	 */
	protected function __construct($id=null) {
		parent::__construct('page', $id);

		$this->setAttr('isfolder', 1);
	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#defineColumns()
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('created', DataTypes::DATETIME, 255, true);
		parent::addColumn('parent_id', DataTypes::INT, false, true);
		parent::addColumn('isfolder', DataTypes::INT, false, true);

	}

	/**
	 *
	 * @param string $foldername
	 */
	public static function create($foldername) {
		$page = new PageFolder();
		$page->setAttr('name', $foldername);
		$page->setAttr('created', date("Y-m-d H:i:s"));
	}

	/**
	 *
	 * @param String $foldername
	 */
	public function changeName($foldername) {
		$this->setAttr('name', $foldername);
	}

	public function addPage(Page $page) {

		$page->setParent($this);
		$this->pages[] = $page;
	}


	/**
	 * creational method or factory method.
	 *
	 * @param int $id
	 * @return PageFolder
	 */
	public static function findByID($id) {
		$pagefolder = new PageFolder($id);
		return $pagefolder;
	}

	/**
	 * @param string $foldername
	 * @return PageFolder
	 */
	public static function findByName($foldername) {
		$folders = parent::findAll('page', parent::ALL, new Criteria(' name = :name', array('name' => $foldername)));

		if (count($folders) > 0) {
			return reset($folders);
		}

		return null;
	}

	public static function findInFolder(PageFolder $folder) {
		return parent::findAll('page', parent::ALL, new Criteria(' parent_id = :parentid AND isfolder = :isfolder', array('isfolder' => 1, 'parentid' => $folder->getID())));
	}


	/**
	 * get The pagename
	 *
	 * @return string
	 */
	public function getName() {

		if (!$this->getAttr('name')) {
			return 'root';
		}


		return $this->getAttr('name');
	}

	/**
	 * @return PageFolder
	 */
	public function getParent() {

		if ($this->parent == null) {
			$this->parent = new PageFolder($this->getAttr('parent_id'));
		}

		return $this->parent;
	}

	public function hasParent() {
		if ($this->getAttr('parent_id') == 0) {
			return false;
		}

		return true;
	}

	/**
	 * get underlying folders
	 * 
	 * @return array
	 */
	public function getFolders() {
		if ($this->folders == null) {
			$this->folders = PageFolder::findInFolder($this);
		}
		return $this->folders;
	}

	/**
	 * get underlying pages
	 * 
	 * @return array
	 */
	public function getPages() {
		if ($this->pages == null) {
			$this->pages = Page::findInFolder($this);
		}
		return $this->pages;
	}

}

class PageFolderRecordException extends RecordException {}

