<?php

/**
 * Description of BlogController
 *
 * @author robertcabri
 */
class BlogController extends CmsController {
	//put your code here
	const C_CURRENT_FOLDER = 'currentPageFolder';

	public function __construct($method) {
		// we should check for permissions
		parent::__construct('blog/' . $method, Lang::get('blog.title'));

	}

	public function _index() {

	}

	public function _default() {
		return __CLASS__;
	}

}