<?php

class TemplateTitle extends DomainText {

	public function __construct($value=null) {

		if (empty($value)) {
			throw new InvalidArgumentException('nothing-set', 1);
		}

		if (!preg_match("/^[a-zA-Z0-9_]+$/", $value)) {
			throw new InvalidArgumentException('contains-spaces', 1);
		}
		
		parent::__construct($value, null, 255);
	}
}