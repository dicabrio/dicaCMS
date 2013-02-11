<?php

//Loader::importController('cms/CmsController');

class AreaController extends CmsController {

	public function __construct($sMethod) {
		parent::__construct('page/'.$sMethod, Lang::get('page.title'));
//		parent::__construct($app);

//		$this->app->includeModel('company/company');
//
//		$this->app->includeModel('profile/profile');
//		$this->app->includeModel('profile/profileeditform');
//
//		$this->app->includeModel('general/domainentity');
//		$this->app->includeModel('general/domaintext');
//		$this->app->includeModel('general/textline');
//		$this->app->includeModel('general/requiredtextline');
//		$this->app->includeModel('general/email');
//		$this->app->includeModel('general/requiredemail');
//		$this->app->includeModel('general/address');
//
//		$this->app->includeModel('area/usergroupcollection');
//		$this->app->includeModel('user/username');
//		$this->app->includeModel('user/password');

		$this->view = new View();
		$this->view->assign('title', Lang::get('area.page_title'));
	}

	public function _index() {

		$areas = Area::findAll();
		$userGroups = UserGroup::findAll();
		$form = $this->getAreasForm($areas, $userGroups);

		
		$this->view->assign('areas', $areas);
		$this->view->assign('form', $form);

//		$this->view->render('cms/cms_header');
		;
//		$this->view->render('cms/cms_footer');
		
		$oBaseView = parent::getBaseView();
		$oBaseView->assign('oModule', $this->view->render(Conf::get('general.dir.templates').'/area/area_edit.php', true));
//		$oBaseView->addScript('page.js');

		return $oBaseView->getContents();

	}

	/**
	 *
	 * @param array $areas
	 * @param array $userGroups
	 * @return Form
	 */
	private function getAreasForm($areas, $userGroups) {

		$form = new Form(Conf::get('general.url.cms') . '/area/update', 'post', 'area_edit');

		foreach ($areas as $area) {

			$groups = $area->getUserGroups();
			$groupsValue = array();
			foreach ($groups as $group) {
				$groupsValue[] = $group->getID();
			}

			$userGroupSelect = new Select('area_'.$area->getName().'_user_group');
			$userGroupSelect->addAttribute('multiple', 'multiple');
			$userGroupSelect->setValue($groupsValue);
			foreach ($userGroups as $group) {
				$userGroupSelect->addOption($group->getID(), $group->getTitle());
			}
			$redirectInput = new Input('text', 'area_'.$area->getName().'_redirect', $area->getUrl());

			$form->addFormElement($userGroupSelect);
			$form->addFormElement($redirectInput);
		}

		$form->addFormElement(new ActionButton(Lang::get('area.areas_save')));
		return $form;
	}

	/**
	 *
	 */
	public function update() {

		try {
			$this->pdo = DataFactory::getInstance()->getConnection();
			$this->pdo->beginTransaction();

			$areas = Area::findAll();
			$userGroups = UserGroup::findAll();
			$form = $this->getAreasForm($areas, $userGroups);
			$form->listen(Request::getInstance());

			$mapper = new FormMapper();

			foreach ($areas as $area) {

				$mapper->addFormElementToDomainEntityMapping('area_'.$area->getName().'_user_group', 'UserGroupCollection');
				$mapper->addFormElementToDomainEntityMapping('area_'.$area->getName().'_redirect', 'TextLine');
			}

			$mapper->constructModelsFromForm($form);

			foreach ($areas as $area) {
				$areaUserGroups = $mapper->getModel('area_'.$area->getName().'_user_group');
				$areaRedirect = $mapper->getModel('area_'.$area->getName().'_redirect');

				$area->setUrl($areaRedirect);
				$area->removeAllUserGroups();

				foreach ($areaUserGroups->toArray() as $group) {

					$area->addUserGroup($group);
				}

				$area->save();

			}

			$this->pdo->commit();
			$this->getSession()->set('notification', 'area\'s are updated');
			Util::gotoPage(Conf::get('general.url.cms').'/area');
		} catch (FormMapperException $e) {
			
			$this->pdo->rollBack();

			$this->view->assign('areas', $areas);
			$this->view->assign('form', $form);

			$oBaseView = parent::getBaseView();
			$oBaseView->assign('oModule', $this->view->render(Conf::get('general.dir.templates').'/area/area_edit.php', true));

			return $oBaseView->getContents();
		}
	}

	/**
	 *
	 * @param string $keyword
	 * @param int $page
	 */
	public function search($keyword = false, $page = 1) {

		try {
			$searchForm = new Form($this->app->config('core/routing.base_url') . '/profile/search', 'post', 'profile_search');
			$searchForm->addFormElement(new Input('text', 'keyword'));
			$searchForm->addFormElement(new ActionButton($this->app->lang('profile/profile.search_profile')));
			$searchForm->listen($this->getRequest());

			$mapper = new FormMapper();
			$mapper->addFormElementToDomainEntityMapping('keyword', 'DomainText');
			$mapper->constructModelsFromForm($searchForm);

			$keyword = $mapper->getModel('keyword');

			$itemsPerPage = $this->app->config('profile/profile.items_per_page');
			$start = ($page * $itemsPerPage) - $itemsPerPage;

			$profiles = Profile::findByKeyword($keyword);

		} catch (FormMapperException $e) {

		}

		$this->view->assign('errors', $mapper->getMappingErrors());
		$this->view->assign('searchForm', $searchForm);
		$this->view->assign('profiles', $profiles);

		$this->view->render('cms/cms_header');
		$this->view->render('profile/profile_overview');
		$this->view->render('cms/cms_footer');
	}
	
	public function _default() {
		parent::_default();
	}
	
	

	private function delete(Profile $profile) {

		try {

			$this->pdo->beginTransaction();
			$profile->delete();
			$this->pdo->commit();
		} catch (Exception $e) {

			// log this
			$this->getSession()->set('flash', $this->app->lang('profile/profile.profile_not_deletable'));
			$this->pdo->rollBack();
		}


		$this->getResponse()->redirect('/profile');
	}

}