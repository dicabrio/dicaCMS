<?php

class TemplateFileForm extends Form {

	/**
	 *
	 * @var TemplateFile
	 */
	private $tpl;

	/**
	 *
	 * @param Request $req
	 * @param TemplateFile $tpl
	 */
	public function __construct(Request $req, TemplateFile $tpl) {

		$this->tpl = $tpl;
		parent::__construct(Conf::get('general.cmsurl.www').'/template/edittemplate/'.$tpl->getID(), Request::POST, 'templatefileform');

	}

	protected function defineFormElements() {

		$tplid = new Input('hidden', 'template_id', $this->tpl->getID());
		$this->addFormElement($tplid);

		$tplname = new Input('text', 'title', $this->tpl->getTitle());
		$this->addFormElement($tplname);

		// Modules
		$modules = Module::getForTemplates();
		$tplModule = new Select('module_id');
		$tplModule->setValue($this->tpl->getModule()->getID());
		foreach ($modules as $module) {
			$tplModule->addOption($module->getID(), $module->getName());
		}
		$this->addFormElement($tplModule);

		$tpldescription = new TextArea('description', $this->tpl->getDescription());
		$this->addFormElement($tpldescription);

		$tplsource = new TextArea('source', $this->tpl->getSource());
		$this->addFormElement($tplsource);

	}

}