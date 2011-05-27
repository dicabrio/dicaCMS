<?php


class MediaFolderSaveHandler implements FormHandler {

/**
 * @var FormMapper
 */
	private $formmapper;

	/**
	 * @var Folder
	 */
	private $mediafolder;

	/**
	 * @var Folder
	 */
	private $parentfolder;

	/**
	 * @param FormMapper $formmapper
	 * @param PageFolder $pagefolder
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Folder $pagefolder, Folder $folder) {

		$this->formmapper = $formmapper;
		$this->mediafolder = $pagefolder;
		$this->parentfolder = $folder;

	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {

		try {
			
			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->constructModelsFromForm($oForm);
			$this->mediafolder->update($this->formmapper->getModel('name'), $this->formmapper->getModel('description'));
			$this->parentfolder->addChild($this->mediafolder);
//			$this->mediafolder->show();
			$this->mediafolder->save();

			$data->commit();
			Util::gotoPage(Conf::get('general.url.cms').'/media/folder/'.$this->parentfolder->getID());
			
		} catch (PageRecordException $e) {
			$oForm->getFormElement('template_id')->notMapped();
			$this->formmapper->addMappingError('page', $e->getMessage());

		} catch (FormMapperException $e) {
			$data->rollBack();
		}
		
	}

}