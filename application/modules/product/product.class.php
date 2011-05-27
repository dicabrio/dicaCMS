<?php


class Product extends DataRecord {

	/**
	 *
	 * @var Media
	 */
	private $image;

	/**
	 *
	 * @var Media
	 */
	private $categoryImage;

	/**
	 *
	 * @var Media
	 */
	private $detailImage;

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
		parent::addColumn('type', DataTypes::VARCHAR, 255, true);
		parent::addColumn('price', DataTypes::VARCHAR, 255, true);
		parent::addColumn('created', DataTypes::DATETIME, false, true);
		parent::addColumn('publishtime', DataTypes::DATETIME, false, true);
		parent::addColumn('expiretime', DataTypes::DATETIME, 255, true);
		parent::addColumn('summary', DataTypes::TEXT, false, true);
		parent::addColumn('body', DataTypes::TEXT, false, true);

		parent::addColumn('image_id', DataTypes::INT, false, true);
		parent::addColumn('detailimage_id', DataTypes::INT, false, true);

	}

	public function getCreated() {

		return $this->getAttr('created');
		
	}

	/**
	 * @return string
	 */
	public function getTitle() {

		return $this->getAttr('title');
		
	}

	/**
	 * @param RequiredTextLine $name
	 */
	public function setTitle(RequiredTextLine $name) {

		$this->setAttr('title', $name->getValue());

	}

	/**
	 * @return string
	 */
	public function getType() {

		return $this->getAttr('type');

	}

	/**
	 * @param string $name
	 */
	public function setType($name) {

		$this->setAttr('type', $name);

	}

	/**
	 * @return string
	 */
	public function getPrice() {

		return $this->getAttr('price');

	}

	/**
	 * @param string $name
	 */
	public function setPrice($name) {

		$this->setAttr('price', $name);

	}
	
	/**
	 * @return Date
	 */
	public function getPublishTime() {

		$time = $this->getAttr('publishtime');
		if ('0000-00-00 00:00:00' === $this->getAttr('publishtime') || empty($time)) {
			return new Date('now');
		}

		return new Date($this->getAttr('publishtime'));
	}

	/**
	 * @param Date $publishtime
	 */
	public function setPublishTime(Date $publishtime=null) {

		$this->setAttr('publishtime', $publishtime);

	}

	/**
	 * @return Date
	 */
	public function getExpireTime() {

		$time = $this->getAttr('expiretime');
		if ('0000-00-00 00:00:00' === $this->getAttr('expiretime') || empty($time)) {
			return '';
		}

		return new Date($this->getAttr('expiretime'));
	}

	/**
	 * @param Date $expiretime
	 */
	public function setExpireTime(Date $expiretime = null) {

		$this->setAttr('expiretime', (string) $expiretime);
		
	}

	/**
	 * @return string
	 */
	public function getSummary() {

		return $this->getAttr('summary');
		
	}

	/**
	 * @param DomainText $summary
	 */
	public function setSummary(DomainText $summary) {

		$this->setAttr('summary', $summary);
		
	}

	/**
	 * @return string
	 */
	public function getBody() {

		return $this->getAttr('body');

	}

	/**
	 * @param DomainText $body
	 */
	public function setBody(DomainText $body) {

		$this->setAttr('body', $body);

	}

	/**
	 * @return Media
	 */
	public function getImage() {

		if ($this->image == null) {
			$this->image = new Media($this->getAttr('image_id'));
		}

		return $this->image;

	}

	/**
	 * @param Media $image
	 */
	public function setImage(Media $image) {

		if ($image->getID() == 0) {
			return;
		}

		$this->image = $image;

		$this->setAttr('image_id', $this->image->getID());

	}

	/**
	 * @return Media
	 */
	public function getDetailImage() {

		if ($this->detailImage == null) {
			$this->detailImage = new Media($this->getAttr('detailimage_id'));
		}

		return $this->detailImage;

	}

	/**
	 * @param Media $image
	 */
	public function setDetailImage(Media $image) {

		if ($image->getID() == 0) {
			return;
		}

		$this->detailImage = $image;
		$this->setAttr('detailimage_id', $this->detailImage->getID());

	}

	/**
	 * @return string
	 */
	public function  __toString() {

		return $this->getName();

	}

	/**
	 *
	 * @return array
	 */
	public static function findAll() {

		return parent::findAll(__CLASS__, parent::ALL);

	}

	public static function findTypeActive($type, $numberIncrement=10, $numberStart=0) {

		$numberIncrement = intval($numberIncrement);
		if ($numberIncrement == 0) {
			$numberIncrement = 10;
		}

		$now = date('Y-m-d H:i:s');
		$crit = new Criteria("type = :type
			AND publishtime < :time
			AND (expiretime = '0000-00-00 00:00:00' OR expiretime > :time)", array('type' => $type, 'time' => $now));

		$limit = intval($numberStart).','.$numberIncrement;
		if ($numberIncrement == -1) {
			$limit = null;
		}

		$order = 'publishtime DESC';
		if ($type == 'agenda') {
			$order = 'publishtime ASC';
		}
		
		return parent::findAll(__CLASS__, parent::ALL, $crit, $order, $limit);
	}

	/**
	 *
	 * @param string $name
	 * @return Tag
	 */
	public static function findByTitle($name) {
//parent::findAll($sTableName, $columns, $conditions, $orderings, $limit);
		$result = parent::findAll(__CLASS__, parent::ALL, new Criteria("title = :name", array('name' => $name)), 'publishtime DESC');
		if (count($result) > 0) {
			return reset($result);
		}

		return null;
	}
}