<?php


class Password extends DomainText {
	public function __construct($value) {
		parent::__construct($value, 6, 255);
	}
}