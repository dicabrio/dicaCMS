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
	 *
	 * @var DataFactory
	 */
	private $data;
	
	/**
	 *
	 * @var PageEditViewBuilder
	 */
	private $viewBuilder;

	/**
	 * @param FormMapper $formmapper
	 * @param Page $page
	 * @param PageFolder $folder
	 */
	public function __construct(FormMapper $formmapper, Page $page, PageEditViewBuilder $viewBuilder) {
		$this->formmapper = $formmapper;
		$this->page = $page;
		$this->data =  DataFactory::getInstance();
		$this->viewBuilder = $viewBuilder;
	}

	private function updatePage() {

		$this->page->update($this->formmapper->getModel('pagename'),
				$this->formmapper->getModel('template_id'),
				$this->formmapper->getModel('publishtime'),
				$this->formmapper->getModel('expiretime'),
				$this->formmapper->getModel('title'),
				$this->formmapper->getModel('keywords'),
				$this->formmapper->getModel('description'),
				$this->formmapper->getModel('type'));

		$this->page->setActive(intval("".$this->formmapper->getModel('active')));
	}

	/**
	 * @param Form $form
	 */
	public function handleForm(Form $form) {
		try {

			$this->data->beginTransaction();
			$this->viewBuilder->addFormMapping($this->formmapper);
			
			$this->formmapper->constructModelsFromForm($form);
			$this->updatePage();


			foreach ($this->viewBuilder->getPageModuleControllers() as $oModuleController) {
				$oModuleController->handleData();
			}

			$this->page->save();
			$this->data->commit();
			
			$pressedButton = $form->getPressedButton();
			
			if ($pressedButton->getName() == 'action_reload') {
				Util::gotoPage(Conf::get('general.cmsurl.www').'/page/editpage/'.$this->page->getID());
			}
			
			// need to check fi there is a special redirect to another controller
			Util::gotoPage(Conf::get('general.cmsurl.www').'/page/folder/'.$this->page->getParent()->getID());

		} catch (PageRecordException $e) {
			$form->getFormElement('template_id')->notMapped();
			$this->formmapper->addMappingError('page', $e->getMessage());

		} catch (FormMapperException $e) {
			$this->data->rollBack();
		}
	}

}