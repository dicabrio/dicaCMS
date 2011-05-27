<?php

class PageEditForm extends Form {

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @param Request $oReq
	 * @param array $aElements
	 */
	public function __construct(Page $page) {
		$this->page = $page;

		$redirect = 'editpage';
		parent::__construct(Conf::get('general.url.cms') . '/page/' . $redirect . '/' . $page->getID(), Request::POST, 'pageform');
	}

	/**
	 * @TODO add modules of the page as form element.
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'page_id');
		$elPageID->setValue($this->page->getID());

		parent::addFormElement($elPageID);

		$elPageType = new Select('type');
		$pageTypes = PageType::findAll();
		foreach ($pageTypes as $pageType) {

			$elPageType->addOption($pageType->getName(), $pageType->getLabel());
		}
		$elPageType->setValue($this->page->getType());

		parent::addFormElement($elPageType);

		$elPagename = new Input('text', 'pagename');
		$elPagename->setValue($this->page->getName());

		parent::addFormElement($elPagename);

		$elTitle = new Input('text', 'title');
		$elTitle->setValue($this->page->getTitle());

		parent::addFormElement($elTitle);

		$elPublishTime = new Input('text', 'publishtime');
		$elPublishTime->setValue($this->page->getPublishTime());

		parent::addFormElement($elPublishTime);

		$elExpireTime = new Input('text', 'expiretime');
		$elExpireTime->setValue($this->page->getExpireTime());

		parent::addFormElement($elExpireTime);

		$elRedirect = new Input('text', 'redirect');
		$elRedirect->setValue($this->page->getRedirect());

		parent::addFormElement($elRedirect);

		$elKeywords = new TextArea('keywords');
		$elKeywords->setValue($this->page->getKeywords());

		parent::addFormElement($elKeywords);

		$elDescription = new TextArea('description');
		$elDescription->setValue($this->page->getDescription());

		parent::addFormElement($elDescription);

		$elActive = new CheckboxInput('active');
		$elActive->setValue($this->page->isActive());

		parent::addFormElement($elActive);
	}

	public function addTemplates($templates) {
		$elTemplate = new Select('template_id');
		try {
			$elTemplate->setValue($this->page->getTemplate()->getID());
		} catch (RecordException $e) {
			$elTemplate->setValue(0);
		}
		$elTemplate->addOption(0, 'Select template..');
		foreach ($templates as $template) {
			$elTemplate->addOption($template->getID(), $template->getTitle());
		}

		parent::addFormElement($elTemplate);
	}

	public function addUserGroups($allUserGroups, $selectedUserGroups = array()) {
		foreach ($allUserGroups as $userGroup) {
			$formField = new CheckboxInput('usergroup_' . $userGroup->getID());

			parent::addFormElement($formField);
		}
	}

}