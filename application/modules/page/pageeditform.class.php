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

		$redirect = 'savepage';
		if ($page->getID() == 0) {
			$redirect = 'saveeditpage';
		}
		parent::__construct(Conf::get('general.cmsurl.www').'/page/'.$redirect.'/'.$page->getID(), Request::POST, 'pageform');
	}

	/**
	 * @TODO add modules of the page as form element.
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'page_id');
		$elPageID->setValue($this->page->getID());

		parent::addFormElement($elPageID);

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

		$button = new ActionButton(Lang::get('general.button.save'));
		$button->addAttribute('class', 'save button');

		parent::addFormElement($button);

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
			$formField = new CheckboxInput('usergroup_'.$userGroup->getID());

			parent::addFormElement($formField);
		}
	}
}