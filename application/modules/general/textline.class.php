<?php

class TextLine extends DomainText {

	public function __construct($value=null) {
		parent::__construct($value, null, 255);
	}
}