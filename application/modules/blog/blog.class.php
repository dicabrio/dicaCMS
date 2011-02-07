<?php
/**
 * Description of Blog
 *
 * Every blog is in fact a page. This page is of a type: 'blog' :)
 *
 * @author robertcabri
 */
class Blog extends Page {

	public function  __construct($id = null) {
		parent::__construct($id);

		if ($id > 0) {
			$this->setAttr('type', 'blog');
		}
	}

	public static function findAll() {

		$blogs = parent::findAll('Page', parent::ALL, new Criteria("type=:type", array('type' => 'blog')));
		return $blogs;

	}

	public static function findActive($numberIncrement=10, $numberStart=0) {

		$numberIncrement = intval($numberIncrement);
		if ($numberIncrement == 0) {
			$numberIncrement = 10;
		}

		$now = date('Y-m-d H:i:s');
		$crit = new Criteria("type=:type 
			AND active = :active
			AND publishtime < :time
			AND (expiretime = '0000-00-00 00:00:00' OR expiretime > :time)", array('type' => 'blog', 'active' => 1, 'time' => $now));

		return parent::findAll('Page', parent::ALL, $crit, 'created DESC', intval($numberStart).','.$numberIncrement);
	}

	public function countAllActive() {
		
		$now = date('Y-m-d H:i:s');
		return (int)parent::countBySql("SELECT COUNT(1) FROM `page` WHERE type=:type
			AND active = :active
			AND publishtime < :time
			AND (expiretime = '0000-00-00 00:00:00' OR expiretime > :time)", array('type' => 'blog', 'active' => 1, 'time' => $now));
	}

}
