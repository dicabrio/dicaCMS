<?php

class Region extends DataRecord implements DomainEntity {

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
	}

	/**
	 * @return void
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('body', DataTypes::TEXT, 500, true);
		parent::addColumn('idx', DataTypes::VARCHAR, 255, true);
	}

	/**
	 * get the title
	 *
	 * @return string
	 */
	public function getName() {

		return $this->getAttr('name');
	}

	public function getProductGroup() {

//		return Productgroup::findParentByRegion($this);
		return Productgroup::findByRegion($this);
	}

	/**
	 * find all media items
	 *
	 * @return array
	 */
	public static function find() {

		return parent::findAll(__CLASS__, parent::ALL, null, 'idx ASC');
	}

	public static function findByBody($region) {
		$result = parent::findAll(__CLASS__, parent::ALL, new Criteria('body = :body', array('body' => $region)));
		if (count($result) > 0 ) {
			return reset($result);
		}

		return null;
	}

}

class Productgroup extends DataRecord implements DomainEntity {

	private $children = null;
	private $parent = null;
	/**
	 *
	 * @var Region
	 */
	private $region = null;

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
	}

	/**
	 * @return void
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('parent_id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
	}

	/**
	 * get the title
	 *
	 * @return string
	 */
	public function getName() {

		return $this->getAttr('name');
	}

	public function getParentID() {
		return $this->getAttr('parent_id');
	}

	/**
	 * Productgroup
	 */
	public function getParent() {

		if ($this->parent == null) {
			$this->parent = new Productgroup($this->getAttr('parent_id'));
		}

		return $this->parent;
	}

	private function setParent(Productgroup $r) {
		$this->parent = $r;
		$this->setAttr('parent_id', $r->getID());
	}

	public function addChild(Productgroup $r) {

		$this->children[$r->getID()] = $r;
		$r->setParent($this);
	}

	public function getChildren() {
		if ($this->children === null) {
			$this->children = Productgroup::findChildren($this, $this->region);
		}

		return $this->children;
	}

	public function hasChildren() {
		return (count($this->children) > 0);
	}

	public function setRegion(Region $r) {
		$this->region = $r;
	}


	public static function findByRegion(Region $r) {

		$aBind = array('rid' => $r->getID());
		$query = "

			SELECT 	pg.*

			FROM 	region AS r,
					region_productgroup AS rpg,
					productgroup AS pg

			WHERE 	rpg.region_id = r.id
			AND 	rpg.productgroup_id = pg.id
			AND 	r.id = :rid
			AND		pg.parent_id IS NULL

			ORDER BY parent_id ASC";

		$groups = parent::findBySql(__CLASS__, $query, $aBind);
		foreach ($groups as $g) {
			$g->setRegion($r);
		}

		return $groups;
	}

	public static function findChildren(Productgroup $g, Region $r) {

		$aBind = array('rid' => $r->getID(), 'pid' => $g->getID());
		$query = "

			SELECT 	pg.*

			FROM 	region AS r,
					region_productgroup AS rpg,
					productgroup AS pg

			WHERE 	rpg.region_id = r.id
			AND 	rpg.productgroup_id = pg.id
			AND 	r.id = :rid
			AND		pg.parent_id = :pid

			ORDER BY parent_id ASC";

		$groups = parent::findBySql(__CLASS__, $query, $aBind);
		foreach ($groups as $g) {
			$g->setRegion($r);
		}

		return $groups;

	}

}

class Product extends DataRecord implements DomainEntity {

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
	}

	/**
	 * @return void
	 */
	protected function defineColumns() {

//		parent::addColumn('id', DataTypes::INT, false, true);
		parent::addColumn('sku', DataTypes::VARCHAR, 255, true);
		parent::addColumn('basis_id', DataTypes::INT, false, true);
		parent::addColumn('name', DataTypes::VARCHAR, 255, true);
		parent::addColumn('description', DataTypes::VARCHAR, 255, true);
		parent::addColumn('msds_filename', DataTypes::VARCHAR, 255, true);
		parent::addColumn('pds_filename', DataTypes::VARCHAR, 255, true);
		parent::addColumn('productgroup_id', DataTypes::INT, false, true);
	}

	public function getID() {
		return $this->getAttr('sku');
	}

	public function getProductGroupID() {
		return $this->getAttr('productgroup_id');
	}

	/**
	 * get the title
	 *
	 * @return string
	 */
	public function getName() {
		return $this->getAttr('name');
	}

	public function getMsdsFilename() {
		return $this->getAttr('msds_filename');
	}

	public function getDescription() {
		return $this->getAttr('description');
	}

	public function getPdsFilename() {
		return $this->getAttr('pds_filename');
	}

	public function getParentID() {
		return $this->getAttr('parent_id');
	}

	public function getApplications() {
		return Application::findByProduct($this);
	}

	public static function findSpecial() {

		$aBind = array();
		$query = "
			SELECT		p.*, pag.productgroup_id
			FROM		product AS p, product_application AS pa, productgroup_application AS pag
			WHERE		pa.application_id = pag.application_id
				AND		p.sku = pa.sku";

		$productsByID = array();
		$products = parent::findBySql(__CLASS__, $query, $aBind);
		foreach ($products as $g) {
			$productsByID[$g->getProductGroupID()][] = $g;
		}

		return $productsByID;
	}

	public static function findByKeyword($keyword) {


		$query = "SELECT * FROM `product` AS p, `product_application` AS pa, `application` AS a
					WHERE		pa.application_id = a.id
						AND		pa.sku = p.sku
						AND (	p.sku LIKE :keyword OR
								p.name LIKE :keyword OR
								p.description LIKE :keyword OR
								p.msds_filename LIKE :keyword OR
								p.pds_filename LIKE :keyword OR
								a.description LIKE :keyword	)";



		$bind = array('keyword' => '%'.$keyword.'%');

		return parent::findBySql(__CLASS__, $query, $bind);
	}

	public static function findByGroup(Productgroup $group) {

		$aBind = array('pid' => $group->getID());
		$query = "
			SELECT		p.*
			FROM		product AS p, product_group AS pg
			WHERE		p.sku = pg.sku
				AND		pg.productgroup_id = :pid";

		return parent::findBySql(__CLASS__, $query, $aBind);
	}

	public static function find() {
		$aBind = array();
		$query = "
			SELECT		p.*, pag.productgroup_id
			FROM		product AS p, product_application AS pa, productgroup_application AS pag
			WHERE		pa.application_id = pag.application_id
				AND		p.sku = pa.sku";

		$productsByID = array();
		return parent::findBySql(__CLASS__, $query, $aBind);
	}

	public static function findAll() {
		return parent::findAll(__CLASS__, parent::ALL);
	}

}

/**

 * SELECT * FROM application AS a, product_application AS pa WHERE pa.application_id = a.id AND pa.product_id = :pid
 */
class Application extends DataRecord implements DomainEntity {

	/**
	 * @param int $id
	 * @return void
	 */
	public function __construct($id=null) {

		parent::__construct(__CLASS__, $id);
	}

	/**
	 * @return void
	 */
	protected function defineColumns() {

		parent::addColumn('id', DataTypes::INT, false, true);
//		parent::addColumn('sku', DataTypes::VARCHAR, 255, true);
//		parent::addColumn('basis_id', DataTypes::INT, false, true);
		parent::addColumn('description', DataTypes::VARCHAR, 255, true);
//		parent::addColumn('description', DataTypes::VARCHAR, 255, true);
//		parent::addColumn('msds_filename', DataTypes::VARCHAR, 255, true);
//		parent::addColumn('pds_filename', DataTypes::VARCHAR, 255, true);
//		parent::addColumn('productgroup_id', DataTypes::INT, false, true);
	}

	public function getDescription() {
		return $this->getAttr('description');
	}

	public static function findByProduct(Product $p) {
		$aBind = array('pid' => $p->getID());
		$query = "SELECT * FROM application AS a, product_application AS pa WHERE pa.application_id = a.id AND pa.sku = :pid";

		return parent::findBySql(__CLASS__, $query, $aBind);
	}
}