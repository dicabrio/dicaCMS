<?php

class PageController extends CmsController {

	const C_CURRENT_FOLDER = 'currentPageFolder';

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('page/'.$sMethod, 'Pages');

//		$oMainMenu = parent::getMainMenu();
//		$oMainMenu->addItem(new MenuItem(Conf::get('general.url.www').Conf::get('page.url.editpage'), 'new Page', ''));
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
		$pages = $folder->getPages();
		$subfolders = $folder->getFolders();

		$breadcrumbFac = new BreadcrumbFactory($folder, Conf::get('general.url.www').'/page');
		$breadcrumb = $breadcrumbFac->build();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editpage', 'new Page'));
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editfolder', 'new Folder'));

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($subfolders);
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
	 * edit an existing page
	 * @return string
	 */
	public function editpage($aErrors = array(), $aModuleErrors=array()) {

		$oReq = Request::getInstance();
		$oSession = Session::getInstance();

		$pagefolder = PageFolder::findByID($oSession->get(self::C_CURRENT_FOLDER));
		$oPage = new Page(Util::getUrlSegment(2));
		
		$aTemplates = TemplateFile::getFiles();

		$form = new PageEditForm($oReq, $oPage, $aTemplates);
		
		$formmapper = new PageMapper($form);

		$button = new ActionButton('Save');
		$button->addAttribute('class', 'save');

		$form->addSubmitButton('save', $button, new PageSaveHandler($formmapper, $oPage, $pagefolder));
		$form->listen();

		$breadcrumb = new Menu('breadcrumb');
		$breadcrumb->addItem(new MenuItem(Conf::get('general.url.www').'/page/folder/'.$pagefolder->getID(), $pagefolder->getName()));

		$breadcrumbname = 'edit Page';
		if ($oPage->getID() == 0) {
			$breadcrumbname = 'new Page';
		}

		$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));

		$oModuleView = new View('page/editpage.php');
		$oModuleView->assign('form', $form);
		$oModuleView->assign('folderid', $pagefolder->getID());
		$oModuleView->assign('pageid', $oPage->getID());
		$oModuleView->assign('aModules', array());
		$oModuleView->assign('breadcrumb', $breadcrumb);
		$oModuleView->assign('aErrors', $formmapper->getMappingErrors());

		try {
			$oTemplateFile = $oPage->getTemplate();
			$oViewParser = new ViewParser(new FileManager($oTemplateFile->getFullPath()));

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

		} catch (RecordException $e) {
			$aErrors[] = 'template.removedtemplate';
			$oModuleView->assign('iTemplateID', $oReq->post('template_id', 0));
		}

		$oBaseView = parent::getBaseView();
		$oBaseView->addScript('tabbing.js');
		$oBaseView->assign('oModule', $oModuleView);

		return $oBaseView->getContents();
	}


	public function _default() {
		return 'PageController';
	}
}