<?php
/**
 * Special type of controller. Only needed to show pages
 *
 * @author robertcabri
 * @package CMS
 */
class ViewPageController {

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @var Session;
	 */
	private $session;

	public function __construct() {
		// we should check for permissions
		// change the template directory. This differs from the standard

		$this->request = Request::getInstance();
		$this->session = Session::getInstance();

	}

	public function show($sPagename) {
		$oPage = Page::findByName($sPagename);
		if ($oPage === null) {
			return 'page cannot be found<br />';
		}

		$this->mayShow($oPage);

		$oView = $this->getView($oPage);
		
		$oView->assign('wwwurl', Conf::get('general.url.www'));
		$oView->assign('imagesurl', Conf::get('general.url.images'));
		$oView->assign('jsurl', Conf::get('general.url.js'));
		$oView->assign('cssurl', Conf::get('general.url.css'));

		$oView->assign('pagename', $oPage->getName());

		$oView->assign('title', $oPage->getTitle());
		$oView->assign('description', $oPage->getDescription());
		$oView->assign('keywords', $oPage->getKeywords());
		
		$this->populateViewWithModules($oPage, $oView);
		return $oView->getContents();

	}

	private function redirect($sRedirect, $type = null) {
		if (empty($sRedirect)) {
			$sRedirect = Conf::get('general.url.www');
		}
		if (!preg_match('/^http:\/\//', $sRedirect)) {
			$sRedirect = Conf::get('general.url.www').$sRedirect;
		}

		if ($type == '301') {
			header("HTTP/1.1 301 Moved Permanently" );
		}
		header("Location: ".$sRedirect );
		exit;
	}

	private function mayShow(Page $oPage) {

		$sToday = strtotime('now');
		$sPublish = strtotime($oPage->getPublishTime());
		$sExpire = $oPage->getExpireTime();

		if ($sExpire == '0000-00-00 00:00:00' || empty($sExpire)) {
			$sExpire = strtotime('now +1second');
		} else {
			$sExpire = strtotime($sExpire);
		}

		if ($sPublish >= $sToday || $sToday >= $sExpire || !$oPage->isActive() || $oPage->getTemplate() === null) {
			$this->redirect($oPage->getRedirect(), '301');
		}

		$oAuth = Authentication::getInstance(Authentication::C_AUTH_SESSIONNAME);
		$user = $oAuth->getUser();
		$area = Area::findByPage($oPage);

		try {
			$user->watch($area);
		} catch (UserException $e) {
			$this->session->set('flash', 'access-denied');
			$this->session->set('front-end-redirect', $oPage->getName().'.html');
			$this->redirect('/'.$area->getUrl());
		}
	}

	private function getView(Page $oPage) {

		$oTemplateFile = $oPage->getTemplate();
		return new View(Conf::get('upload.dir.templates').'/'.$oTemplateFile->getFilename());
		
	}

	private function populateViewWithModules(Page $oPage, View $oView) {

		$oTemplateFile = $oPage->getTemplate();
		$oViewParser = new ViewParser($oTemplateFile);

		foreach ($oViewParser->getLabels() as $aModule) {
			$sContent = '';
			$sLabel = ViewParser::constructLabel($aModule['module'], $aModule['id']);
			$oModule = $oPage->getModule($aModule['id']);
			
			if ($oModule instanceof PageModule) {

				$sModuleClass = $oModule->getType().'PageModule';
				$oReflection = new ReflectionClass($sModuleClass);
				$oModuleController = new $sModuleClass($oModule, $oPage, $this->request);

				$sContent = $oModuleController->getContents();
			}

			$oView->assign($sLabel, $sContent);
		}

	}
}