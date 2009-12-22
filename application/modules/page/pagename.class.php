<?php

class PageName extends DomainText {

	public function __construct($value=null) {

		if (empty($value)) {
			throw new InvalidArgumentException('empty', 1);
		}

		if (preg_match('/\s/',$value)) {
			throw new InvalidArgumentException('containingspaces', 1);
		}

		parent::__construct($value, null, 255);
	}
}