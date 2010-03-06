<?php


class PageFolderSaveHandler implements FormHandler {

/**
 * @var FormMapper
 */
	private $formmapper;

	/**
	 * @var PageFolder
	 */
	private $pagefolder;

	/**
	 * @var PageFolder
	 */
	private $parentfolder;

	/**
	 * @param FormMapper $formmapper
	 * @param PageFolder $pagefolder
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, PageFolder $pagefolder, PageFolder $folder) {

		$this->formmapper = $formmapper;
		$this->pagefolder = $pagefolder;
		$this->parentfolder = $folder;

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
			$this->pagefolder->update($this->formmapper->getModel('name'), $this->formmapper->getModel('description'));
			$this->parentfolder->addChild($this->pagefolder);
			$this->pagefolder->save();

			$data->commit();
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.$this->parentfolder->getID());
		} catch (PageRecordException $e) {
			$oForm->getFormElement('template_id')->notMapped();
			$this->formmapper->addMappingError('page', $e->getMessage());

		} catch (FormMapperException $e) {
			$data->rollBack();
		}
		
	}

}