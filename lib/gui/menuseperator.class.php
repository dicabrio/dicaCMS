<?php


class MenuSeperator extends Template {
	
	public function __construct($sAction, $sLabel, $sIdentifier) {
		$this->assign('action', $sAction);
		$this->assign('label', $sLabel);
		$this->assign('identifier', $sIdentifier);
		$this->assign('icon', '');
		$this->setTemplateContents('<li class="[[identifier]]"><a href="[[action]]">[[icon]][[label]]</li>');
	}
	
	public function setIcon(Image $oImage) {
		$sImage = $oImage->getPath().'/'.$oImage->getFilename();
		$this->assign('icon', '<img src="'.$sImage.'" alt="" />');
	}
	
}