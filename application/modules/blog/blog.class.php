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

}
