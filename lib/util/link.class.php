<?php

class Link {
	private $sLink;
	private $sLabel;

	public function __construct($sLink, $sLabel=false) {
		$this->sLink = $sLink;
		$this->sLabel = $sLabel;
	}

	public function getLink() {
		return $this->sLink;
	}

	public function getLabel() {
		return $this->sLabel;
	}
}