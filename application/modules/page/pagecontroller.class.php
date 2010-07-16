<?php

class PageController extends CmsController {

	const C_CURRENT_FOLDER = 'currentPageFolder';

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('page/'.$sMethod, Lang::get('page.title'));
	}

	/**
	 * @return string
	 */
	public function folder($sId='') {
		$iItemID = intval(Util::getUrlSegment(2));
		return $this->_index(array(), $iItemID);
	}

	public function _index($aErrors = array(), $iParentID=0, $sSuccess = false) {

		$session = Session::getInstance();
		$session->set(self::C_CURRENT_FOLDER, $iParentID);

		$folder = new PageFolder($iParentID);
		$stuff = $folder->getChildren();

		$breadcrumbFac = new BreadcrumbFactory($folder, Conf::get('general.url.www').'/page');
		$breadcrumb = $breadcrumbFac->build();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editpage', Lang::get('page.button.newpage')));
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editfolder', Lang::get('page.button.newfolder')));

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($stuff);

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
		$oBaseView->addScript('page.js');

		return $oBaseView->getContents();
	}

	/**
	 * @TODO create a pageview object that will populate the view with variables and such
	 *
	 * edit an existing page
	 * @return string
	 */
	public function editpage() {

		$oReq = Request::getInstance();
		$oSession = Session::getInstance();

		$pagefolder = new PageFolder($oSession->get(self::C_CURRENT_FOLDER));
		$oPage = new Page(Util::getUrlSegment(2));

		$aTemplates = TemplateFile::getFiles(current(Module::getForTemplates('page')));

		$form = new PageEditForm($oReq, $oPage, $aTemplates);

		$formmapper = new PageMapper($form);

		$button = new ActionButton(Lang::get('general.button.save'));
		$button->addAttribute('class', 'save');

		$breadcrumb = new Menu('breadcrumb');
		$breadcrumb->addItem(new MenuItem(false, Lang::get('breadcrumb.here')));
		$folderName = $pagefolder->getName();
		if ($folderName == '') {
			$folderName = Lang::get('breadcrumb.root');
		}
		$breadcrumb->addItem(new MenuItem(Conf::get('general.url.www').'/page/folder/'.$pagefolder->getID(), $folderName));

		$breadcrumbname = Lang::get('page.breadcrumb.editpage', $oPage->getName());
		if ($oPage->getID() == 0) {
			$breadcrumbname = Lang::get('page.breadcrumb.newpage');
		}

		$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));

		$oModuleView = new View('page/editpage.php');
		$oModuleView->assign('form', $form);
		$oModuleView->assign('folderid', $pagefolder->getID());
		$oModuleView->assign('pageid', $oPage->getID());
		$oModuleView->assign('aModules', array());
		$oModuleView->assign('breadcrumb', $breadcrumb);
		$oModuleView->assign('aErrors', $formmapper->getMappingErrors());

		$oPageModules = $oPage->getModules();
		$cmsModules = array();
		$cmsModuleViews = array();
		try {
			$oTemplateFile = $oPage->getTemplate();
			$oViewParser = new ViewParser($oTemplateFile);

			foreach ($oViewParser->getLabels() as $aModule) {
				$sModuleClass = $aModule['module'].'CmsModule';

				$oPageModule = $oPage->getModule($aModule['id']);
				if ($oPageModule === null) {
					$oPageModule = new PageModule();
					$oPageModule->setType($aModule['module']);
					$oPageModule->setIdentifier($aModule['id']);

					$oPage->addModule($oPageModule);
				}

				$oModule = new $sModuleClass($oPageModule, $form, $formmapper, $this);

				if ($oModule instanceof CmsModuleController) {
					$oModView = $oModule->getEditor();
					if ($oModView instanceof View) {
						$oModView->sIdentifier = $oModule->getIdentifier();
						$cmsModuleViews[] = $oModView;
					}
					$cmsModules[] = $oModule;
				}

				unset($oPageModules[$aModule['id']]);
			}

			foreach ($oPageModules as $key => $pagemodule) {
				$pagemodule->delete();
				unset($oPageModules[$key]);
			}

		} catch (RecordException $e) {
			$aErrors[] = 'template.removedtemplate';
			$oModuleView->assign('iTemplateID', $oReq->post('template_id', 0));
		}


		$form->addSubmitButton('save', $button, new PageSaveHandler($formmapper, $oPage, $cmsModules, $pagefolder));
		$form->listen();

		$oModuleView->assign('aModules', $cmsModuleViews);
		$oModuleView->assign('aErrors', $formmapper->getMappingErrors());

		$oBaseView = parent::getBaseView();
		$oBaseView->addScript('tabbing.js');

		$oBaseView->assign('oModule', $oModuleView);

		return $oBaseView->getContents();
	}

	public function editfolder() {
		$req = Request::getInstance();
		$session = Session::getInstance();

		$parentPageFolder = new PageFolder($session->get(self::C_CURRENT_FOLDER));
		$currentPageFolder = new PageFolder(Util::getUrlSegment(2));

		$button = new ActionButton('Save');

		$form = new PageFolderEditForm($req, $currentPageFolder);
		$formmapper = new PageFolderMapper($form);
		$form->addSubmitButton('save', $button, new PageFolderSaveHandler($formmapper, $currentPageFolder, $parentPageFolder));
		$form->listen();

		$breadcrumb = new Menu('breadcrumb');
		$breadcrumb->addItem(new MenuItem(false, Lang::get('breadcrumb.here')));
		$folderName = $parentPageFolder->getName();
		if ($folderName == '') {
			$folderName = Lang::get('breadcrumb.root');
		}
		$breadcrumb->addItem(new MenuItem(Conf::get('general.url.www').'/page/folder/'.$parentPageFolder->getID(), $folderName));

		$breadcrumbname = Lang::get('page.breadcrumb.editpagefolder', $currentPageFolder->getName());
		if ($currentPageFolder->getID() == 0) {
			$breadcrumbname = Lang::get('page.breadcrumb.newpagefolder');
		}

		$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));

		$oModuleView = new View('page/editpagefolder.php');
		$oModuleView->assign('form', $form);
		$oModuleView->assign('folderid', $parentPageFolder->getID());
		$oModuleView->assign('pageid', $currentPageFolder->getID());
		$oModuleView->assign('breadcrumb', $breadcrumb);
		$oModuleView->assign('aErrors', $formmapper->getMappingErrors());

		$view = parent::getBaseView();
		$view->assign('oModule', $oModuleView);
		return $view->getContents();
	}

	public function deletepage() {

		$aErrors = array();
		$data = parent::getConnection();
		$data->beginTransaction();

		try {
			$page = new Page(intval(Util::getUrlSegment(2)));
			$page->delete();

			$data->commit();

			$session = Session::getInstance();
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.intval($session->get(self::C_CURRENT_FOLDER)));
		} catch (RecordException $e) {
			$aErrors[] = 'page.somthingwrong';
			$aErrors[] = $e->getMessage();
		}

		$data->rollBack();
		return $this->_index($aErrors);

	}

	public function deletefolder() {

		$aErrors = array();
		$data = parent::getConnection();
		$data->beginTransaction();

		try {

			$pageFolder = new PageFolder(intval(Util::getUrlSegment(2)));
			$pageFolder->delete();

			$data->commit();

			$session = Session::getInstance();
			Util::gotoPage(Conf::get('general.url.www').'/page/folder/'.intval($session->get(self::C_CURRENT_FOLDER)));

		} catch (RecordException $e) {
			$aErrors[] = 'database.recordnotexists';
		}

		$data->rollBack();
		return $this->_index($aErrors);
	}


	public function _default() {
		return 'PageController';
	}
}