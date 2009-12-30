<?php


class TemplateFolderMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {

		//$this->addFormElementToDomainEntityMapping('folder_id', 'TemplateFileFolder');
		$this->addFormElementToDomainEntityMapping('name', 'RequiredTextLine');
		$this->addFormElementToDomainEntityMapping('description', 'DomainText');
		
	}
}