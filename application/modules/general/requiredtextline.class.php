<?php

class RequiredTextLine extends TextLine {

	public function __construct($value=null) {
		if (empty($value)) {
			throw new InvalidArgumentException('nothing-set', 1);
		}
		parent::__construct($value);
	}
}