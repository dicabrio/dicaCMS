<?php

class TemplateFileMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {

		//$this->addFormElementToDomainEntityMapping('folder_id', 'TemplateFileFolder');
		$this->addFormElementToDomainEntityMapping('title', 'RequiredTextLine');
		$this->addFormElementToDomainEntityMapping('description', 'DomainText');
		$this->addFormElementToDomainEntityMapping('source', 'DomainText');

	}

}