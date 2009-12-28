<?php


class PageFolderMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {
		//$this->addFormElementToDomainEntityMapping('folder_id', 'PageFolder');
		$this->addFormElementToDomainEntityMapping('name', 'TextLine');
		$this->addFormElementToDomainEntityMapping('description', 'DomainText');
	}
}