<?php

/**
 * Every controller should implement this interface
 *
 */
interface Controller {

	/**
	 * Index when no metod is specified
	 * @return string
	 */
	public function _index();

	/**
	 * Default method if no other method is found
	 * @return string
	 */
	public function _default();

	/**
	 * redirect to a certain url. Given url should not hold the host. This will be
	 * so it will redirect something like this: /report/edit/
	 * not: http://www.example.com/report/edit/
	 */
	public function _redirect($url);

}

