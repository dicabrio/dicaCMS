<?php

class BlogarchivePageModule implements PageModuleController {

	/**
	 * @var PageModule
	 */
	private $pageModule;
	/**
	 * @var Page
	 */
	private $page;
	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var PageModuleController
	 */
	private $imageUploadModule;
	/**
	 * @var PageModuleController
	 */
	private $textBlockModule;

	/**
	 *
	 * @param PageModule $module
	 * @param Page $oPage
	 * @param Request $request
	 * @return void
	 */
	public function __construct(PageModule $module, Page $page, Request $request) {

		$this->pageModule = $module;
		$this->page = $page;
		$this->request = $request;
	}

	private function buildBlogArray(Page $blog) {

		$pageModule = $blog->getModule('subject');
		$pageTextSubject = PageText::getByPageModule($pageModule);

		$pageModule = $blog->getModule('summary');
		$pageTextSummary = PageText::getByPageModule($pageModule);

		return array('subject' => $pageTextSubject->getContent(), 'name' => $blog->getName(), 'summary' => $pageTextSummary->getContent());

	}

	/**
	 * get contents for this module as a string or an object that has a __toString method implemented
	 *
	 * @return string
	 */
	public function getContents() {

		$oTextContent = PageText::getByPageModule($this->pageModule);
		$formshizzle = explode(',', $oTextContent->getContent());

		$amountToStart = 0;
		$amountPerPage = intval($formshizzle[0]);
		$page = intval($this->request->get('page'));

		if ($page > 1) {
			$amountToStart = ($page * $amountPerPage) - $amountPerPage;
		} else {
			$page = 1;
		}

		$activeBlogs = Blog::findActive($amountPerPage, $amountToStart);
		$amountOfActiveBlogs = Blog::countAllActive();

		$blogArticlesForTemplate = array();
		foreach ($activeBlogs as $blog) {
			$blogArticlesForTemplate[] = $this->buildBlogArray($blog);
		}

		try {

			$tplFile = new TemplateFile($formshizzle[1]);
			$view = new View(Conf::get('upload.dir.templates').'/'.$tplFile->getFilename());
			$view->assign('wwwurl', Conf::get('general.url.www'));
			$view->assign('articles', $blogArticlesForTemplate);
//			$view->assign('pages', ceil($amountOfActiveBlogs / $amountPerPage));
//			$view->assign('page', $page);
			
			return $view;
		} catch (Exception $e) {

			$str = '<ul id="blogrecent">';
			foreach ($activeBlogs as $blog) {
				$str .= '<li><a href="'.$blog->getName().'">'.$blog->getTitle().'</a></li>';
			}
			$str .= '</ul>';

			return $str;
		}
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return '';
	}

}