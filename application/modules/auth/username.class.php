<?php

class Username extends DomainText {
	public function  __construct($sValue) {
		parent::__construct($sValue, 3, 255);
	}
}