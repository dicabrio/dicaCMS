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
	
	/**
	 * @var Request
	 */
	private $request;

	public function __construct($sMethod) {
		// we should check for permissions
		parent::__construct('page/' . $sMethod, Lang::get('page.title'));

		$this->session = $this->getSession();
		$this->request = Request::getInstance();
	}

	/**
	 *
	 * @param int $id
	 * @return string
	 */
	public function folder($id = 0) {
		return $this->_index($id);
	}

	/**
	 *
	 * @param int $folderID
	 * @return string
	 */
	public function _index($folderID = 0) {

		$aErrors = array();
		$sSuccess = '';

		$session = $this->getSession();
		$session->set(self::C_CURRENT_FOLDER, $folderID);

		$folder = new PageFolder($folderID);
		$stuff = $folder->getChildren();

		$actions = new ActionMenu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.cmsurl.www') . '/page/editpage', Lang::get('page.button.newpage')));
		$actions->addItem(new MenuItem(Conf::get('general.cmsurl.www').'/page/editfolder', Lang::get('page.button.newfolder')));

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
		
		$saveReloadButton = new Input('submit', 'action_reload', Lang::get('general.button.save_reload'));
		$saveReloadButton->addAttribute('class', 'saven button');

		$button = new ActionButton(Lang::get('general.button.save'));
		$button->addAttribute('class', 'save button');

		$saveHandler = new PageSaveHandler($this->formMapper, $page, $pageEditView);
		$this->form->addSubmitButton($button, $saveHandler);
		$this->form->addSubmitButton($saveReloadButton, $saveHandler);
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
		
		$parentPageFolder = new PageFolder($this->session->get(self::C_CURRENT_FOLDER));
		$currentPageFolder = new PageFolder(Util::getUrlSegment(2));

		$button = new ActionButton('Save');

		$form = new PageFolderEditForm($currentPageFolder);
		$formmapper = new PageFolderMapper($form);
		$form->addSubmitButton($button, new PageFolderSaveHandler($formmapper, $currentPageFolder, $parentPageFolder));
		$form->listen($this->request);

		$breadcrumb = new ActionMenu('breadcrumb');
		$breadcrumb->addItem(new MenuItem(false, Lang::get('breadcrumb.here')));
		$folderName = $parentPageFolder->getName();
		if ($folderName == '') {
			$folderName = Lang::get('breadcrumb.root');
		}
		$breadcrumb->addItem(new MenuItem(Conf::get('general.url.cms') . '/page/folder/' . $parentPageFolder->getID(), $folderName));

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

		} catch (RecordException $e) {
			$data->rollBack();
//			$aErrors[] = 'page.somthingwrong';
//			$aErrors[] = $e->getMessage();
		}

		Util::gotoPage(Conf::get('general.url.cms') . '/page/folder/' . intval($this->session->get(self::C_CURRENT_FOLDER)));
//		return $this->_index($aErrors);
	}

	/**
	 * 
	 * @return string
	 */
	public function deletefolder() {

		$aErrors = array();
		$data = parent::getConnection();
		$data->beginTransaction();

		try {

			$pageFolder = new PageFolder(intval(Util::getUrlSegment(2)));
			$pageFolder->delete();

			$data->commit();

		} catch (RecordException $e) {
			$aErrors[] = 'database.recordnotexists';
			$data->rollBack();
		}

		Util::gotoPage(Conf::get('general.url.cms') . '/page/folder/' . intval($this->session->get(self::C_CURRENT_FOLDER)));
		//return $this->_index($aErrors);
	}

	public function _default() {
		return 'PageController';
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
	
	/**
	 *
	 * @param Page $page
	 * @param array $templates
	 * @param array $userGroups 
	 */
	private function getEditPageForm(Page $page, $templates, $userGroups) {
		if ($this->form === null) {
			$this->form = new PageEditForm($page);
			$this->form->addTemplates($templates);
			$this->form->addUserGroups($userGroups);
		}

		if ($this->formMapper === null) {
			$this->formMapper = new PageMapper();
		}
	}

}