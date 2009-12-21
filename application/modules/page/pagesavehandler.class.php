<?php


class PageSaveHandler implements FormHandler {

/**
 * @var FormMapper
 */
	private $formmapper;

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @var PageFolder
	 */
	private $folder;

	/**
	 * @param FormMapper $formmapper
	 * @param Page $page
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Page $page, PageFolder $folder) {
		$this->formmapper = $formmapper;
		$this->page = $page;
		$this->folder = $folder;
	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {
		try {

			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->constructModelsFromForm();
			$this->page->update($this->formmapper->getModel('pagename'),
				$this->formmapper->getModel('template_id'),
				$this->formmapper->getModel('publishtime'),
				$this->formmapper->getModel('expiretime'),
				$this->formmapper->getModel('keywords'),
				$this->formmapper->getModel('description'));

			$this->page->setActive($this->formmapper->getModel('active'));
			$this->folder->addPage($this->page);

			$oTemplateFile = $this->page->getTemplate();
			$oViewParser = new ViewParser($oTemplateFile->getFullPath());
			foreach ($oViewParser->getLabels() as $aModule) {

				$sModuleClass = $aModule['module'].'Controller';
				$oPageModule = $oPage->getModule($aModule['id']);

				if ($oPageModule === null) {
					$oPageModule = new PageModule();
					$oPageModule->setType($aModule['module']);
					$oPageModule->setIdentifier($aModule['id']);

					$oPage->addModule($oPageModule);
				}

				$oModule = new $sModuleClass($oPageModule);

				if ($oModule instanceof ModuleController) {
					$oModule->handleData($oReq);
				}
			}

			$this->page->save();
			$data->commit();
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.$this->folder->getID());
		} catch (PageRecordException $e) {
			$oForm->getFormElement('template_id')->notMapped();
			$this->formmapper->addMappingError('page', $e->getMessage());

		} catch (FormMapperException $e) {
			$data->rollBack();
		}
	}

}