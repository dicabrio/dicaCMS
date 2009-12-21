<?php

class PageEditForm extends Form {
	
	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @var array
	 */
	private $templates;

	/**
	 * @param Request $oReq
	 * @param array $aElements
	 */
	public function __construct(Request $oReq, Page $page, $templates) {
		$this->page = $page;
		$this->templates = $templates;

		parent::__construct($oReq, Conf::get('general.url.www').'/page/editpage/'.$page->getID(), Request::POST, 'pageform');
	}

	/**
	 * 
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'page_id');
		$elPageID->setValue($this->page->getID());

		parent::addFormElement($elPageID->getName(), $elPageID);

		$elPagename = new Input('text', 'pagename');
		$elPagename->setValue($this->page->getName());

		parent::addFormElement($elPagename->getName(), $elPagename);

		$elTemplate = new Select('template_id');
		$elTemplate->setValue($this->page->getTemplate()->getID());
		$elTemplate->addOption(0, 'Select template..');
		foreach ($this->templates as $template) {
			$elTemplate->addOption($template->getID(), $template->getTitle());
		}

		parent::addFormElement($elTemplate->getName(), $elTemplate);

		$elPublishTime = new Input('text', 'publishtime');
		$elPublishTime->setValue($this->page->getPublishTime());

		parent::addFormElement($elPublishTime->getName(), $elPublishTime);

		$elExpireTime = new Input('text', 'expiretime');
		$elExpireTime->setValue($this->page->getExpireTime());

		parent::addFormElement($elExpireTime->getName(), $elExpireTime);

		$elRedirect = new Input('text', 'redirect');
		$elRedirect->setValue($this->page->getRedirect());

		parent::addFormElement($elRedirect->getName(), $elRedirect);

		$elKeywords = new TextArea('keywords');
		$elKeywords->setValue($this->page->getKeywords());

		parent::addFormElement($elKeywords->getName(), $elKeywords);

		$elDescription = new TextArea('description');
		$elDescription->setValue($this->page->getDescription());

		parent::addFormElement($elDescription->getName(), $elDescription);

		$elActive = new CheckboxInput('active');
		$elActive->setValue($this->page->isActive());

		parent::addFormElement($elActive->getName(), $elActive);
		
	}
}