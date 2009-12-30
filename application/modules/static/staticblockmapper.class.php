<?php

class StaticBlockMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {

		$this->addFormElementToDomainEntityMapping('identifier', 'RequiredTextLine');
		$this->addFormElementToDomainEntityMapping('content', 'DomainText');

	}

}