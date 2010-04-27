<?php

class TemplateFileMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {

		//$this->addFormElementToDomainEntityMapping('folder_id', 'TemplateFileFolder');
		$this->addFormElementToDomainEntityMapping('title', 'TemplateTitle');
		$this->addFormElementToDomainEntityMapping('module_id', 'Module');
		$this->addFormElementToDomainEntityMapping('description', 'DomainText');
		$this->addFormElementToDomainEntityMapping('source', 'DomainText');

	}

}