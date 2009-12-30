<?php


class TemplateFileSaveHandler implements FormHandler {

/**
 * @var FormMapper
 */
	private $formmapper;

	/**
	 * @var TemplateFile
	 */
	private $template;

	/**
	 * @var Folder
	 */
	private $parentfolder;

	/**
	 * @param FormMapper $formmapper
	 * @param TemplateFile $template
	 * @param TemplateFileFolder $parentFolder
	 */
	public function __construct(FormMapper $formmapper, TemplateFile $template, TemplateFileFolder $parentFolder) {

		$this->formmapper = $formmapper;
		$this->template = $template;
		$this->parentfolder = $parentFolder;

	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {

		try {
			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->constructModelsFromForm();
			
			$this->template->setTitle($this->formmapper->getModel('title'));
			$this->template->setDescription($this->formmapper->getModel('description'));
			$this->template->setSource($this->formmapper->getModel('source'));

			$this->parentfolder->addChild($this->template);

			$this->template->save();

			$data->commit();
			Util::gotoPage(Conf::get('general.url.www').'/template/folder/'.$this->parentfolder->getID());

		} catch (RecordException $e) {

			$this->formmapper->addMappingError('template', $e->getMessage());

		} catch (FormMapperException $e) {
			// catch it
		}

		$data->rollBack();
	}

}