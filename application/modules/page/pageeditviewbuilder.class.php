<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of PageEditViewBuilder
 *
 * @author robertcabri
 */
class PageEditViewBuilder {

	/**
	 *
	 * @var Folder
	 */
	private $folder;

	/**
	 * @var page
	 */
	private $page;

	/**
	 *
	 * @var View
	 */
	private $view;

	/**
	 *
	 * @var Form
	 */
	private $form;

	/**
	 *
	 * @var array
	 */
	private $pageModuleControllers;

	/**
	 *
	 * @var array
	 */
	private $pageModuleControllerViews;

	/**
	 * @param Folder $folder
	 * @param Page $page
	 */
	public function __construct(Page $page) {

		$this->page = $page;
		$this->folder = $page->getParent();

		$this->view = new View(Conf::get('general.dir.templates').'/page/editpage.php');

		$this->view->assign('folderid', $this->folder->getID());
		$this->view->assign('pageid', $this->page->getID());
		$this->view->assign('aModules', array());
		$this->view->assign('aErrors', array());

		$this->buildBreadcrumb();

	}

	/**
	 * @return Menu
	 */
	private function buildBreadcrumb() {

		$breadcrumbFac = new BreadcrumbFactory($this->folder, Conf::get('general.url.www').'/page');
		$breadcrumb = $breadcrumbFac->build();

		if ($this->page !== null) {

			$breadcrumbname = Lang::get('page.breadcrumb.editpage', $this->page->getName());
			if ($this->page->getID() == 0) {
				$breadcrumbname = Lang::get('page.breadcrumb.newpage');
			}

			$breadcrumb->addItem(new MenuItem(false, $breadcrumbname));
		}

		$this->view->assign('breadcrumb', $breadcrumb);
	}

	/**
	 *
	 * @param string $cmsModuleControllerName
	 * @return CmsModuleController
	 */
	private function buildCmsModuleController(PageModule $pageModule) {

		$sModuleClass = $pageModule->getType().'CmsModule';
		$moduleController = new $sModuleClass($pageModule, $this->form);
		
		return $moduleController;

	}

	private function buildPageModuleViews() {

		$pageModules = $this->page->getModules();
		$this->pageModuleControllers = array();
		$this->pageModuleControllerViews = array();
		foreach ($pageModules as $pageModule) {

			$moduleController = $this->buildCmsModuleController($pageModule);
			$this->pageModuleControllers[] = $moduleController;
			$this->pageModuleControllerViews[] = $moduleController->getEditor();

		}

	}

	/**
	 * @param Form $form
	 */
	public function buildFormForModules(Form $form) {

		$this->form = $form;

		try {

			$this->buildPageModuleViews();

		} catch (RecordException $e) {
			$aErrors[] = 'template.removedtemplate';
			$oModuleView->assign('iTemplateID', $req->post('template_id', 0));
		}

		$this->view->assign('form', $this->form);
		$this->view->assign('aModules', $this->pageModuleControllerViews);

	}

	public function addFormMapping(FormMapper $mapper) {

		foreach ($this->pageModuleControllers as $moduleController) {
			$moduleController->addFormMapping($mapper);
		}
	}

	/**
	 *
	 * @return array
	 */
	public function getPageModuleControllers() {

		return $this->pageModuleControllers;
		
	}

	/**
	 *
	 * @return View
	 */
	public function getView() {

		return $this->view;
		
	}

}
