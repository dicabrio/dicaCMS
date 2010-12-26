<?php
/**
 * Description of BlogController
 *
 * @author robertcabri
 */
class BlogController extends CmsController {
	
	//put your code here
	const C_CURRENT_FOLDER = 'currentPageFolder';

	public function __construct($method) {
		// we should check for permissions
		parent::__construct('blog/'.$method, Lang::get('blog.title'));

		$this->getSession()->set('pagesavedredirect', 'blog');

	}

	public function _index() {

		$blogItems = Blog::findAll();

		$actions = new Menu('actions');
		$actions->addItem(new MenuItem(Conf::get('general.cmsurl.www').'/blog/editblog', Lang::get('blog.button.newblog')));

		$oPageDataSet = new PageDataSet();
		$oPageDataSet->setValues($blogItems);

		$oTable = new Table($oPageDataSet);

		$blogOverview = new View(Conf::get('general.dir.templates').'/page/pageoverview.php');
		$blogOverview->assign('aErrors', array());
		$blogOverview->assign('sSucces', false);
		$blogOverview->assign('actions', $actions);
		$blogOverview->assign('oOverview', $oTable);

		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $blogOverview);

		return $oBaseView->getContents();
	}

	/**
	 *
	 * edit an existing page
	 * @return string
	 */
	public function editblog() {

		$blogFolderNameSetting = Setting::getByName('blogfoldername');

		// get the folder for blog pages
		$folder = PageFolder::findByName($blogFolderNameSetting->getValue());
		if ($folder == null) {
			$folder = new PageFolder();
			$folder->update($blogFolderNameSetting->getValue(), '');
			$folder->hide();
			$folder->save();
		}

		// get the template for blog pages
		$blogTemplateIDSetting = Setting::getByName('blogtemplateid');
		$template = new TemplateFile($blogTemplateIDSetting->getValue());

		$blogID = Util::getUrlSegment(2);
		$blog = new Blog($blogID);
		$blog->setTemplate($template);
		$blog->setParent($folder);

		$this->getSession()->set('page', $blog);

		$this->_redirect('page/editpage/'.$blogID);

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
			Util::gotoPage(Conf::get('general.cmsurl.www').'/page/folder/'.intval($session->get(self::C_CURRENT_FOLDER)));

		} catch (RecordException $e) {
			$aErrors[] = 'page.somthingwrong';
			$aErrors[] = $e->getMessage();
		}

		$data->rollBack();
		return $this->_index($aErrors);

	}


	public function _default() {
		return __CLASS__;
	}
}