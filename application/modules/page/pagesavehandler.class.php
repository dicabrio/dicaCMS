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
	 * @var array
	 */
	private $cmsModules;

	/**
	 *
	 * @var DataFactory
	 */
	private $data;

	/**
	 * @param FormMapper $formmapper
	 * @param Page $page
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Page $page, $cmsModules, PageFolder $folder) {
		$this->formmapper = $formmapper;
		$this->page = $page;
		$this->cmsModules = $cmsModules;
		$this->folder = $folder;
		
		$this->data =  DataFactory::getInstance();
	}

	private function updatePage() {

		$this->page->update($this->formmapper->getModel('pagename'),
				$this->formmapper->getModel('template_id'),
				$this->formmapper->getModel('publishtime'),
				$this->formmapper->getModel('expiretime'),
				$this->formmapper->getModel('title'),
				$this->formmapper->getModel('keywords'),
				$this->formmapper->getModel('description'));

		$this->page->setActive($this->formmapper->getModel('active'));
		$this->folder->addChild($this->page);

	}

	/**
	 * @param Form $oForm
	 */
	public function handleForm(Form $oForm) {
		try {

			$this->formmapper->constructModelsFromForm($oForm);
			
			$this->data->beginTransaction();
			$this->updatePage();
			
			foreach ($this->cmsModules as $oModule) {
				if ($oModule instanceof CmsModuleController) {
					$oModule->handleData();
				}
			}

			$this->page->save();
			$this->data->commit();

			// need to check fi there is a special redirect to another controller
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.$this->folder->getID());

		} catch (PageRecordException $e) {
			$oForm->getFormElement('template_id')->notMapped();
			$this->formmapper->addMappingError('page', $e->getMessage());

		} catch (FormMapperException $e) {
			$this->data->rollBack();
//			$this->getSession()->set('error', $this->formmapper->getMappingErrors());
		}
	}

}