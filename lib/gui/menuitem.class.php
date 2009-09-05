<?php


class MenuItem {

	const C_ICONPOS_BEFORE = 0;

	const C_ICONPOS_AFTER = 1;

	private $oImage;

	private $sLink;

	private $sLabel;

	private $sIdentifier = null;

	private $iImagePos;

	private $bActive;

	public function __construct($sLink, $sLabel, $sIdentifier=false, $bActive=false) {
		$this->sLink = $sLink;
		$this->sLabel = $sLabel;
		if ($sIdentifier !== false) {
			$this->sIdentifier = $sIdentifier;
		}

		$this->bActive = $bActive;
	}

	public function setIcon(Image $oImage, $iPos=self::C_ICONPOS_BEFORE) {
		$this->oImage = $oImage;
		$this->iImagePos = $iPos;
	}

	public function setActive($bActive) {
		$this->bActive = $bActive;
	}

	public function getLink() {
		return $this->sLink;
	}

	public function getLabel() {
		return $this->sLabel;
	}

	public function getIdentifier() {
		$sIdentifier = $this->sIdentifier;
		if ($this->bActive === true) {
			$sIdentifier .= ' active';
		}
		return $sIdentifier;
	}

	public function isActive() {
		return $this->bActive;
	}

}