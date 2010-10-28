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

		parent::__construct(Conf::get('general.url.www').'/page/savepage/'.$page->getID(), Request::POST, 'pageform');
	}

	/**
	 * @TODO add modules of the page as form element.
	 */
	protected function defineFormElements() {

		$elPageID = new Input('hidden', 'page_id');
		$elPageID->setValue($this->page->getID());

		parent::addFormElement($elPageID->getName(), $elPageID);

		$elPagename = new Input('text', 'pagename');
		$elPagename->setValue($this->page->getName());

		parent::addFormElement($elPagename->getName(), $elPagename);

		$elTitle = new Input('text', 'title');
		$elTitle->setValue($this->page->getTitle());

		parent::addFormElement($elTitle->getName(), $elTitle);

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

		$button = new ActionButton(Lang::get('general.button.save'));
		$button->addAttribute('class', 'save button');

		parent::addFormElement('save', $button);

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

		parent::addFormElement($elTemplate->getName(), $elTemplate);
	}

	public function addUserGroups($allUserGroups, $selectedUserGroups = array()) {
		foreach ($allUserGroups as $userGroup) {
			$formField = new CheckboxInput('usergroup['.$userGroup->getID().']');
			$formField->setValue(0);

			parent::addFormElement('usergroup_'.$userGroup->getID(), $formField);
		}
	}
}