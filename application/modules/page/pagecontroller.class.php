<?php

class PageController extends CmsController {

	const C_CURRENT_FOLDER = 'currentPageFolder';

	/**
	 * @var Page
	 */
	private $page;

	/**
	 * @var Form
	 */
	private $form;

	/**
	 * @var FormMapper
	 */
	private $formMapper;

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

		$session = $this->getSession();
		$session->set(self::C_CURRENT_FOLDER, $iParentID);
		$session->set('pagesavedredirect', null);

		$folder = new PageFolder($iParentID);
		$stuff = $folder->getChildren();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editpage', Lang::get('page.button.newpage')));
//		$actions->addItem(new MenuItem(Conf::get('general.url.www').'/page/editfolder', Lang::get('page.button.newfolder')));

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($stuff);

		$oTable = new Table($oPageDataSet);

		$oPageOverview = new View(Conf::get('general.dir.templates').'/page/pageoverview.php');
		$oPageOverview->assign('aErrors', $aErrors);
		$oPageOverview->assign('actions', $actions);
		$oPageOverview->assign('oOverview', $oTable);
		$oPageOverview->assign('oBreadCrumb', $this->buildBreadcrumb($folder));
		$oPageOverview->assign('sSearchFormAction', Conf::get('general.url.www').Conf::get('page.url.searchpage'));
		$oPageOverview->assign('sPageFormAction', Conf::get('general.url.www').Conf::get('page.url.showpage'));
		$oPageOverview->assign('sSucces', $sSuccess);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $oPageOverview);
		$oBaseView->addScript('page.js');

		return $oBaseView->getContents();
	}

	/**
	 * @param Page $oPage
	 * @param Folder $pagefolder
	 * @return Menu
	 */
	private function buildBreadcrumb(Folder $pagefolder, Page $oPage=null) {

		$breadcrumbFac = new BreadcrumbFactory($pagefolder, Conf::get('general.url.www').'/page');
		$breadcrumb = $breadcrumbFac->build();

		if ($oPage !== null) {

			$breadcrumbname = Lang::get('page.breadcrumb.editpage', $oPage->getName());
			if ($oPage->getID() == 0) {
				$breadcrumbname = Lang::get('page.breadcrumb.newpage');
			}

			$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));
		}

		return $breadcrumb;
	}

	private function getEditPageForm($page, $templates, $userGroups) {
		if ($this->form === null) {
			$this->form = new PageEditForm($page);
			$this->form->addTemplates($templates);
			$this->form->addUserGroups($userGroups);
		}

		if ($this->formMapper === null) {
			$this->formMapper = new PageMapper();
		}

	}

	/**
	 *
	 * edit an existing page
	 * @return string
	 */
	public function editpage() {

		$oReq = Request::getInstance();
		$session = $this->getSession();

		// it could be there is a page set in the session by another controller
		// and redirected to here to edit.
		$page = $session->get('page');
		if ($page == null) {
			$page = new Page(Util::getUrlSegment(2));
			if ($page->getParent()->getID() == 0) {
				$pagefolder = new PageFolder($session->get(self::C_CURRENT_FOLDER));
				$page->setParent($pagefolder);
			}
		}

		$session->set('page', null);
		$session->set(self::C_CURRENT_FOLDER, $page->getParent()->getID());

		$pageBuilder = new PageBuilder($page);
		$page = $pageBuilder->buildPageFromTemplate();

		$templates = TemplateFile::findByModule(current(Module::getForTemplates('page')));
		$userGroups = UserGroup::findAll();

		// view stuff
		$this->getEditPageForm($page, $templates, $userGroups);

		$pageEditView = new PageEditViewBuilder($page);
		$pageEditView->buildFormForModules($this->form);
		$view = $pageEditView->getView();
		$view->assign('aErrors', $this->formMapper->getMappingErrors());
		$view->assign('pagesavedredirect', $session->get('pagesavedredirect'));
		$view->assign('userGroups', $userGroups);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $view);
		return $oBaseView->getContents();
	}

	public function savepage() {

		// page inladen
		$userGroups = UserGroup::findAll();
		$templates = TemplateFile::findByModule(current(Module::getForTemplates('page')));
		$page = new Page(Util::getUrlSegment(2));
		$pageBuilder = new PageBuilder($page);
		$folder = new PageFolder($this->getSession()->get(self::C_CURRENT_FOLDER));
		$this->formMapper = new PageMapper();

		$page->setParent($folder);
		$page = $pageBuilder->buildPageFromTemplate();
		$this->getEditPageForm($page, $templates, $userGroups);

		$pageEditView = new PageEditViewBuilder($page);
		$pageEditView->buildFormForModules($this->form);
		$pageEditView->addFormMapping($this->formMapper);

		$this->form->listen(Request::getInstance());
		$data = DataFactory::getInstance();

		try {

			$this->formMapper->constructModelsFromForm($this->form);

			$data->beginTransaction();
			$page->update($this->formMapper->getModel('pagename'),
					$this->formMapper->getModel('template_id'),
					$this->formMapper->getModel('publishtime'),
					$this->formMapper->getModel('expiretime'),
					$this->formMapper->getModel('title'),
					$this->formMapper->getModel('keywords'),
					$this->formMapper->getModel('description'));

			foreach ($pageEditView->getPageModuleControllers() as $oModuleController) {
				$oModuleController->handleData();
			}

			$page->setActive($this->formMapper->getModel('active'));
			$page->save();

			$data->commit();

			$redirect = $this->getSession()->get('pagesavedredirect');
			if ($redirect !== null) {
				$this->getSession()->set('pagesavedredirect', null);
				$this->_redirect($redirect);
			}

			$this->_redirect('page/folder/'.$folder->getID());

		} catch (PageRecordException $e) {

			$data->rollBack();
			$this->form->getFormElement('template_id')->notMapped();
			$this->formmapper->addMappingError('page', $e->getMessage());

		} catch (FormMapperException $e) {

//			$this->getSession()->set('error', $this->formmapper->getMappingErrors());

		}

		return $this->editpage();

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

		$oModuleView = new View(Conf::get('general.dir.templates').'/page/editpagefolder.php');
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