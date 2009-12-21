<?php


class PageMapper extends FormMapper {

	protected function defineFormElementToDomainEntityMapping() {
		$this->addFormElementToDomainEntityMapping('pagename', 'TextLine');
		$this->addFormElementToDomainEntityMapping('template_id', 'TemplateFile');
		$this->addFormElementToDomainEntityMapping('publishtime', 'Date');
		$this->addFormElementToDomainEntityMapping('expiretime', 'Date');
		$this->addFormElementToDomainEntityMapping('redirect', 'TextLine');
//		$this->addFormElementToDomainEntityMapping('active', 'TextLine'); // does this need to be mapped?
	}
}