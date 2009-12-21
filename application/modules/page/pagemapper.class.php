<?php


class PageMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {
		$this->addFormElementToDomainEntityMapping('pagename', 'PageName');
		$this->addFormElementToDomainEntityMapping('template_id', 'TemplateFile');
		$this->addFormElementToDomainEntityMapping('publishtime', 'Date');
		$this->addFormElementToDomainEntityMapping('expiretime', 'Date');
		$this->addFormElementToDomainEntityMapping('title', 'TextLine');
		$this->addFormElementToDomainEntityMapping('redirect', 'TextLine');
	}
}