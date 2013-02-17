<?php

class StaticBlockMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {

		$this->addFormElementToDomainEntityMapping('name', 'RequiredTextLine');
		$this->addFormElementToDomainEntityMapping('identifier', 'TemplateTitle');
		$this->addFormElementToDomainEntityMapping('content', 'DomainText');

	}

}