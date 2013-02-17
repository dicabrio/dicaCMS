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

		$oView = $oPage->draw(Conf::get('upload.dir.templates'), $this->request);
		$oView->assign('wwwurl', Conf::get('general.url.www'));
		$oView->assign('imagesurl', Conf::get('general.url.images'));
		$oView->assign('jsurl', Conf::get('general.url.js'));
		$oView->assign('cssurl', Conf::get('general.url.css'));
		$oView->assign('uploadurl', Conf::get('general.url.www').Conf::get('upload.url.general'));

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
			$this->session->set('front-end-redirect', Conf::get('general.url.www').'/'.$oPage->getName());
			$this->redirect('/'.$area->getUrl());
		}
	}

}