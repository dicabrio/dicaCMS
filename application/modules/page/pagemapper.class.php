<?php


class PageMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {
		$this->addFormElementToDomainEntityMapping('type', 'RequiredTextLine');
		$this->addFormElementToDomainEntityMapping('pagename', 'PageName');
		$this->addFormElementToDomainEntityMapping('template_id', 'TemplateFile');
		$this->addFormElementToDomainEntityMapping('publishtime', 'Date');
		$this->addFormElementToDomainEntityMapping('expiretime', 'Date');
		$this->addFormElementToDomainEntityMapping('title', 'RequiredTextLine');
		$this->addFormElementToDomainEntityMapping('redirect', 'TextLine');
	}
}