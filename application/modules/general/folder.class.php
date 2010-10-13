<?php
/**
 * Generic Folder type of the CMS. This folder holds basic stuff a folders needs to know.
 * This folder can be extended for specific folder implementations.
 *
 * Something like PageFolder or TemplateFolder
 *
 * @author robertcabri
 */
class Folder extends DataRecord implements IFolder {

	private $parent;

	private $children;

	private $folders;

	/**
	 * constructor
	 *
	 * @param string $associationtype
	 * @param int $id
	 */
	public function __construct($associationtype, $id=null) {

		parent::__construct('Folder', $id);

		$this->setAttr('associationtype', $associationtype);

		if ($id == 0) {
			$this->setAttr('created', date("Y-m-d H:i:s"));
			$this->setAttr('visible', 1);
		}

	}

	/**
	 * (non-PHPdoc)
	 * @see data/DataRecord#defineColumns()
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('associationtype', DataTypes::VARCHAR, 255, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('description', DataTypes::TEXT, false, true);
		parent::addColumn('created', DataTypes::DATETIME, 255, true);
		parent::addColumn('folder_id', DataTypes::INT, false, true);
		parent::addColumn('visible', DataTypes::INT, false, true);

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
	 * Get the description
	 *
	 * @return string
	 */
	public function getDescription() {

		return $this->getAttr('description');

	}

	/**
	 * It returns the type of objectname this folder is associated with.
	 * For example. if this folder is associated with Pages. This method will return "Pages"
	 *
	 * @return string
	 */
	public function getAssociationType() {

		return $this->getAttr('associationtype');

	}



	/**
	 * @param string $foldername
	 * @return Folder
	 */
	public function update($foldername, $description) {

		$this->setAttr('name', $foldername);
		$this->setAttr('description', $description);
		return $this;
		
	}

	/**
	 *
	 * @param Object $child
	 * @return Folder
	 */
	public function addChild($child) {

		$associationtype = $this->getAttr('associationtype');

		if ($child instanceof Folder && $child->getAssociationType() != $associationtype) {
			$error = 'Trying to add a folder of with different associationtype. '
				.'This folders is associated with '.$associationtype
				.'The child is associated with '.$child->getAssociationType();
			throw new FolderException($error);
		} else {
			$child->setParent($this);
			$this->folders[] = $child;
			return true;
		}

		if (!($child instanceof $associationtype)) {
			$error = 'The given object cannot be added as a child. This Folder is associated with '.$associationtype
				.'. You are adding a '.get_class($child);
			throw new FolderException($error);
		} else {
			$child->setParent($this);
			$this->children[] = $child;
			return true;
		}

		return $this;

	}

	/**
	 * @param Folder $folder
	 * @return Folder
	 */
	public function setParent(Folder $folder) {

		$this->setAttr('folder_id', $folder->getID());
		return $this;
		
	}

	/**
	 * @return Folder
	 */
	public function getParent() {

		if ($this->parent == null) {
			$associationtype = $this->getAttr('associationtype');
			$parentfolder = ucfirst($associationtype).'Folder';

			$this->parent = new $parentfolder($this->getAttr('folder_id'));
		}

		return $this->parent;

	}

	/**
	 * @return has a parent
	 */
	public function hasParent() {

		if ($this->getAttr('id') == 0) {
			return false;
		}

		return true;
	}

	/**
	 * get underlying children
	 *
	 * @return array
	 */
	public function getChildren() {

		return array_merge($this->getFolders(), $this->getItems());

	}

	/**
	 * get underlying folders
	 *
	 * @return array
	 */
	public function getFolders() {

		if ($this->folders == null) {
			$this->folders = array();
			$associationtype = $this->getAttr('associationtype');
			$o = new stdClass();
			$parentfolder = ucfirst($associationtype).'Folder';

			$ref = new ReflectionClass($parentfolder);
			$refMethod = $ref->getMethod('findInFolder');
			$this->folders = $refMethod->invokeArgs($o, array($this, true));
		}
		return $this->folders;

	}

	/**
	 * get underlying pages
	 *
	 * @return array
	 */
	public function getItems() {

		if ($this->children == null) {
			$associationtype = $this->getAttr('associationtype');
			$o = new stdClass();
			$ref = new ReflectionClass($associationtype);
			$refMethod = $ref->getMethod('findInFolder');
			$this->children = $refMethod->invokeArgs($o, array($this));
		}
		return $this->children;

	}

	public function hide() {

		$this->setAttr('visible', 0);
	}

	public function show() {

		$this->setAttr('visible', 1);
	}

	/**
	 * check visibility 
	 * @return boolean
	 */
	public function isVisible() {

		if ($this->getAttr('visible') == 1) {
			return true;
		}

		return false;
	}

	/**
	 * could be implemented in another way. This will do for now
	 * @return string
	 */
	public function __toString() {
		return (string)$this->getAttr('id');
	}

	/**
	 * check if an certain object is the same as this
	 * @param mixed $object
	 * @return boolean
	 */
	public function equals($object) {
		$associationtype = ucfirst($this->getAttr('assocationtype')).'Folder';
		if (!($object instanceof $associationtype)) {
			return false;
		}

		if ($object->getID() != $this->getAttr('id')) {
			return false;
		}

		return true;
	}

	public function save() {

		foreach ((array)$this->folders as $folder) {
			$folder->save();
		}
		
		foreach ((array)$this->children as $item) {
			$item->save();
		}

		parent::save();

	}

	public function delete() {

		$this->getFolders();
		foreach ($this->folders as $folder) {
			$folder->delete();

		}
		$this->folders = null;

		$this->getItems();
		foreach ($this->children as $page) {
			$page->delete();
		}
		$this->children = null;

		parent::delete();

	}

	/**
	 * @param Folder $folder
	 * @return array
	 */
	public static function findInFolder(Folder $folder, $showOnlyVisible = false) {

		parent::setRetrieveRawData(true);

		$query = " folder_id = :parentid AND associationtype = :type";
		$bind = array(
						'parentid' => $folder->getID(),
						'type' => $folder->getAssociationType());

		if ($showOnlyVisible === true) {
			$query .= " AND visible = :visible ";
			$bind['visible'] = 1;
		}

		$className = get_class($folder);
		$result = parent::findAll('Folder', parent::ALL, new Criteria($query, $bind));

		$folders = array();
		foreach ($result as $folderrecord) {
			$folder = new $className();
			
			foreach ($folderrecord as $key => $value) {
				$folder->setAttr($key, $value);
			}

			$folders[] = $folder;
		}

		parent::setRetrieveRawData(false);

		return $folders;

	}

	/**
	 *
	 * @param Folder $folderName
	 */
	public static function findByName($className, $folderName) {

		parent::setRetrieveRawData(true);

		$result = parent::findAll('Folder', parent::ALL, new Criteria(' name = :name ', array('name' => $folderName)));

		parent::setRetrieveRawData(false);

		if (count($result) > 0) {

			$folder = new $className();

			$folderrecord = current($result);
			foreach ($folderrecord as $key => $value) {
				$folder->setAttr($key, $value);
			}

			return $folder;
		}

		return null;
	}
}

class FolderException extends RecordException {}