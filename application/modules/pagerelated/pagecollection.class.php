<?php

class PageCollection extends ArrayObject {

	public function  __construct($array = null) {

		if ($array == null) {
			$array = array();
		}

		if (!is_array($array)) {
			$array = array($array);
		}

		parent::__construct($array);
	}
	
}