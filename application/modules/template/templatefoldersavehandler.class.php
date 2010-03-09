<?php


class TemplateFolderSaveHandler implements FormHandler {

/**
 * @var FormMapper
 */
	private $formmapper;

	/**
	 * @var PageFolder
	 */
	private $templateFolder;

	/**
	 * @var PageFolder
	 */
	private $parentfolder;

	/**
	 * @param FormMapper $formmapper
	 * @param TemplateFileFolder $templateFolder
	 * @param TemplateFileFolder $parentFolder
	 */
	public function __construct(FormMapper $formmapper, TemplateFileFolder $templateFolder, TemplateFileFolder $parentFolder) {

		$this->formmapper = $formmapper;
		$this->templateFolder = $templateFolder;
		$this->parentfolder = $parentFolder;

	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {

		try {
			$oReq = Request::getInstance();
			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->constructModelsFromForm($oForm);
			$this->templateFolder->update($this->formmapper->getModel('name'), $this->formmapper->getModel('description'));

			$this->parentfolder->addChild($this->templateFolder);

			$this->templateFolder->save();

			$data->commit();
			Util::gotoPage(Conf::get('general.url.www').'/template/folder/'.$this->parentfolder->getID());

		} catch (RecordException $e) {

			$oForm->getFormElement('folder_id')->notMapped();
			$this->formmapper->addMappingError('template', $e->getMessage());

		} catch (FormMapperException $e) {
			// catch it
		}

		$data->rollBack();
	}

}