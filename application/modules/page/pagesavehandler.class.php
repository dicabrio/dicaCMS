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
			$oReq = Request::getInstance();

			$data =  DataFactory::getInstance();
			$data->beginTransaction();

			$this->formmapper->constructModelsFromForm($oForm);
			$this->page->update($this->formmapper->getModel('pagename'),
				$this->formmapper->getModel('template_id'),
				$this->formmapper->getModel('publishtime'),
				$this->formmapper->getModel('expiretime'),
				$this->formmapper->getModel('title'),
				$this->formmapper->getModel('keywords'),
				$this->formmapper->getModel('description'));

			$this->page->setActive($this->formmapper->getModel('active'));
			$this->folder->addChild($this->page);

			$oTemplateFile = $this->page->getTemplate();
			$view = new View();
			$oViewParser = new ViewParser($oTemplateFile);
			$oPageModules = $this->page->getModules();

			foreach ($oViewParser->getLabels() as $aModule) {

				$sModuleClass = $aModule['module'].'CmsModule';

				if (!isset($oPageModules[$aModule['id']])) {
					$oPageModule = new PageModule();
					$oPageModule->setType($aModule['module']);
					$oPageModule->setIdentifier($aModule['id']);

					$this->page->addModule($oPageModule);

				} else {
					// the type can be updated
					$oPageModule = $oPageModules[$aModule['id']];
					$oPageModule->setType($aModule['module']);
				}

				$oModule = new $sModuleClass($oPageModule);

				if ($oModule instanceof CmsModuleController) {
					$oModule->handleData($oReq);
				}

				unset($oPageModules[$aModule['id']]);
			}

			foreach ($oPageModules as $key => $pagemodule) {
				$pagemodule->delete();
				unset($oPageModules[$key]);
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