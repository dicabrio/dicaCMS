<?php
/**
 * Blog
 *
 * @author robertcabri
 */
class PageExtend extends DataRecord {

	/**
	 * @var Page
	 */
	private $page;

	/**
	 *
	 * @param string $associationtype
	 * @param int $id
	 */
	public function __construct($associationtype, $id = null) {

		parent::__construct(__CLASS__, $id);

		$this->setAttr('associationtype', $associationtype);
		if ($id == 0) {
			$this->setAttr('created', date("Y-m-d H:i:s"));
		}

	}

	/**
	 * 
	 */
	protected function defineColumns() {
		
		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('page_id', DataTypes::VARCHAR, 255, true);
		parent::addColumn('associationtype', DataTypes::VARCHAR, 255, true);
		parent::addColumn('created', DataTypes::DATETIME, 255, true);

	}

	/**
	 * It returns the type of objectname this PageExtend is associated with.
	 * For example. if this PageExtend is associated with blog. This method will return "blog"
	 *
	 * @return string
	 */
	public function getAssociationType() {

		return $this->getAttr('associationtype');

	}

	/**
	 * @return Page
	 */
	public function getPage() {

		if ($this->page === null) {
			$this->page = new Page($this->getAttr('page_id'));
		}
		return $this->page;
		
	}

	/**
	 *
	 * @param Page $page 
	 */
	public function setPage(Page $page) {

		$this->page = $page;
		$this->setAttr('page_id', $page->getID());
		
	}


}
