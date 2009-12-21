<?php

class PageController extends CmsController {

	const C_CURRENT_FOLDER = 'currentPageFolder';

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('page/'.$sMethod, 'Pages');

		$oMainMenu = parent::getMainMenu();
		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').Conf::get('page.url.editpage'), 'new Page', ''));
		//		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').Conf::get('page.url.editfolder'), 'new Folder', ''));
	}

	/**
	 * @return string
	 */
	public function folder($sId='') {
		$iItemID = intval(Util::getUrlSegment(2));
		return $this->_index(array(), $iItemID);
	}

	public function _index($aErrors = array(), $iParentID=0, $sSuccess = false) {

		$oSession = Session::getInstance();
		$oSession->set(self::C_CURRENT_FOLDER, $iParentID);

		$folder = PageFolder::findByID($iParentID);
		$pages = Page::findInFolder($folder);

		$breadcrumbFac = new BreadcrumbFactory($folder, Conf::get('general.url.www').'/page');
		$breadcrumb = $breadcrumbFac->build();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editpage', 'new Page'));
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editfolder', 'new Folder'));

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($pages);

		$oTable = new Table($oPageDataSet);

		$oPageOverview = new View('page/pageoverview.php');
		$oPageOverview->assign('aErrors', $aErrors);
		$oPageOverview->assign('actions', $actions);
		$oPageOverview->assign('oOverview', $oTable);
		$oPageOverview->assign('oBreadCrumb', $breadcrumb);
		$oPageOverview->assign('sSearchFormAction', Conf::get('general.url.www').Conf::get('page.url.searchpage'));
		$oPageOverview->assign('sPageFormAction', Conf::get('general.url.www').Conf::get('page.url.showpage'));
		$oPageOverview->assign('sSucces', $sSuccess);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oPageOverview);

		return $oBaseView->getContents();
	}

	/**
	 * add a new page
	 * @return string
	 */
	public function newpage() {

		return "";
	}

	/**
	 * This method will catch the post variables from the editpage method. It will handle all validation and saving of the page.
	 * If we are on this page we allready know we wanna save the data
	 *
	 * @return return
	 */
	public function updatepage() {

		try {

			$oReq = Request::getInstance();
			$oSession = Session::getInstance();
			$iPageID = 0;
			$iParentID = intval($oSession->get(self::C_CURRENT_FOLDER));

			// if we pressed cancel...
			if ($oReq->post('action') == 'cancel') {
				Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.$iParentID);
			}

			$iPageID = $oReq->post('page_id');
			$oPage = new Page($iPageID);

			DataFactory::beginTransaction();
			// saving
			$oTemplateFile = new TemplateFile($oReq->post('template_id'));
			$oPage->setActive(($oReq->post('active') == 1));
			$oPage->setName($oReq->post('pagename'));
			$oPage->setTemplate($oTemplateFile);
			$oPage->setPublishTime($oReq->post('publishtime'));
			$oPage->setExpireTime($oReq->post('expiretime'));
			$oPage->setRedirect($oReq->post('redirect'));

			// set parent dir when a new file is created
			if ($iPageID == 0) {
				$oPage->setParent($iParentID);
			}
			
			$sPath = $oTemplateFile->getPath();
			$sFile = $oTemplateFile->getFilename();
			$oViewParser = new ViewParser($sPath.FileManager::SEP.$sFile);

			$aPageModules = $oPage->getModules();
			$aPageModules = array();
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

			$oPage->save();

			DataFactory::commit();
			// build view and say that we successfully edited a page
			return $this->_index(array(), $iParentID, Lang::get('page.pagesavesucces', $oPage->getName()));

		} catch (RecordException $e) {

			DataFactory::rollBack();
			$aErrors[] = 'template.nosuchtemplate';
			return $this->editpage($aErrors);
		}
	}

	/**
	 * edit an existing page
	 * @return string
	 */
	public function editpage($aErrors = array(), $aModuleErrors=array()) {

		$oReq = Request::getInstance();
		$oSession = Session::getInstance();

		$pagefolder = PageFolder::findByID($oSession->get(self::C_CURRENT_FOLDER));
		$oPage = Page::findByID(Util::getUrlSegment(2));
		
		$aTemplates = TemplateFile::getFiles();

		$form = new PageEditForm($oReq, $oPage, $aTemplates);

		$formmapper = new PageMapper($form);

		$form->addSubmitButton('save', new ActionButton('Save'), new SaveHandler($formmapper));
		$form->listen();


		$oModuleView = new View('page/editpage.php');
		$oModuleView->assign('form', $form);

		$oModuleView->assign('iPageID', $oReq->post('page_id', $oPage->getID()));
		$oModuleView->assign('sPagename', $oReq->post('pagename', $oPage->getName()));
		$oModuleView->assign('aModules', array());

		try {
			$oTemplateFile = $oPage->getTemplate();
			$sPath = $oTemplateFile->getPath();
			$sFile = $oTemplateFile->getFilename();

			$oViewParser = new ViewParser($sPath.FileManager::SEP.$sFile);
			$aPageModules = array();
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
					$oModView = $oModule->getEditor();
					$oModView->sIdentifier = $oModule->getIdentifier();
					$aPageModules[] = $oModView;
				}
			}

			$oModuleView->assign('aModules', $aPageModules);
			$oModuleView->assign('iTemplateID', $oReq->post('template_id', $oTemplateFile->getID()));

		} catch (RecordException $e) {
			$aErrors[] = 'template.removedtemplate';
			$oModuleView->assign('iTemplateID', $oReq->post('template_id', 0));
		}
		$oModuleView->assign('sPublishtime', $oReq->post('publishtime', $oPage->getPublishTime()));
		$oModuleView->assign('sExpiretime', $oReq->post('expiretime', $oPage->getExpireTime()));
		$oModuleView->assign('sRedirect', $oReq->post('redirect', $oPage->getRedirect()));
		$oModuleView->assign('iActive', $oReq->post('active', $oPage->isActive()));
		$oModuleView->assign('sPageEditFormAction', Conf::get('general.url.www').Conf::get('page.url.updatepage'));

		$oModuleView->assign('aErrors', $aErrors);

		$oBaseView = parent::getBaseView();
		$oBaseView->addScript('tabbing.js');
		$oBaseView->assign('oModule', $oModuleView);

		return $oBaseView->getContents();
	}


	public function _default() {
		return 'PageController';
	}
}