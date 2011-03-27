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
	/**
	 *
	 * @var Session
	 */
	private $session;

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('page/' . $sMethod, Lang::get('page.title'));

		$this->session = $this->getSession();
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

		$folder = new PageFolder($iParentID);
		$stuff = $folder->getChildren();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.cmsurl.www') . '/page/editpage', Lang::get('page.button.newpage')));
//		$actions->addItem(new MenuItem(Conf::get('general.cmsurl.www').'/page/editfolder', Lang::get('page.button.newfolder')));

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($stuff);

		$oTable = new Table($oPageDataSet);

		$oPageOverview = new View(Conf::get('general.dir.templates') . '/page/pageoverview.php');
		$oPageOverview->assign('aErrors', $aErrors);
		$oPageOverview->assign('actions', $actions);
		$oPageOverview->assign('oOverview', $oTable);
		$oPageOverview->assign('oBreadCrumb', $this->buildBreadcrumb($folder));
		$oPageOverview->assign('sSearchFormAction', Conf::get('general.cmsurl.www') . Conf::get('page.url.searchpage'));
		$oPageOverview->assign('sPageFormAction', Conf::get('general.cmsurl.www') . Conf::get('page.url.showpage'));
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

		$breadcrumbFac = new BreadcrumbFactory($pagefolder, Conf::get('general.cmsurl.www') . '/page');
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

		$page = new Page(Util::getUrlSegment(2));
		if ($page->getParent()->getID() == 0) {
			$pagefolder = new PageFolder($this->session->get(self::C_CURRENT_FOLDER));
			$page->setParent($pagefolder);
		}

		$this->session->set(self::C_CURRENT_FOLDER, $page->getParent()->getID());

		$templates = TemplateFile::findByModule(current(Module::getForTemplates('page')));
		$userGroups = UserGroup::findAll();

		$this->getEditPageForm($page, $templates, $userGroups);
		// view stuff

		$pageEditView = new PageEditViewBuilder($page);
		$pageEditView->buildFormForModules($this->form);

		$button = new ActionButton(Lang::get('general.button.save'));
		$button->addAttribute('class', 'save button');

		$this->form->addSubmitButton($button, new PageSaveHandler($this->formMapper, $page));
		$this->form->listen($oReq);

		$view = $pageEditView->getView();
		$view->assign('aErrors', $this->formMapper->getMappingErrors());
		$view->assign('pagesavedredirect', $this->session->get('pagesavedredirect'));
		$view->assign('userGroups', $userGroups);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $view);
		$oBaseView->addScript(Conf::get('general.url.js') . '/page.js');
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
		$breadcrumb->addItem(new MenuItem(Conf::get('general.cmsurl.www') . '/page/folder/' . $parentPageFolder->getID(), $folderName));

		$breadcrumbname = Lang::get('page.breadcrumb.editpagefolder', $currentPageFolder->getName());
		if ($currentPageFolder->getID() == 0) {
			$breadcrumbname = Lang::get('page.breadcrumb.newpagefolder');
		}

		$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));

		$oModuleView = new View(Conf::get('general.dir.templates') . '/page/editpagefolder.php');
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
			Util::gotoPage(Conf::get('general.cmsurl.www') . '/page/folder/' . intval($session->get(self::C_CURRENT_FOLDER)));
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

			Util::gotoPage(Conf::get('general.cmsurl.www') . '/page/folder/' . intval($this->session->get(self::C_CURRENT_FOLDER)));
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