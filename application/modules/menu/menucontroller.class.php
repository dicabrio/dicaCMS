<?php

class MenuController extends CmsController {
	
	const CONTROLLER = 'menu';

	/**
	 * @var Session
	 */
	private $session;
	/**
	 *
	 * @var Form
	 */
	private $form;

	/**
	 * @param string $method
	 */
	public function __construct($method) {

		parent::__construct(self::CONTROLLER . '/' . $method, Lang::get('menu.title'));
		$this->session = Session::getInstance();
	}

	/**
	 * @return View
	 */
	public function _index() {

		$menu = Menu::findAll();

		$view = new View(Conf::get('general.dir.templates') . '/menu/menuindex.php');
		$view->assign('errors', $this->session->get('errors'));
		$view->assign('menus', $menu);
		
		$this->session->set('errors', null);

		$baseView = parent::getBaseView();
		$baseView->assign('oModule', $view);

		return $baseView;
	}

	public function _default() {
		return 'Not implemented yet!';
	}

	/**
	 * @param Menu $menu
	 * @return Form
	 */
	private function buildEditForm(Menu $menu) {

		$name = new Input('text', 'name', $menu->getName());
		$button = new ActionButton('save');

		if ($this->form == null) {
			$this->form = new Form(Conf::get('general.cmsurl.www').'/'.self::CONTROLLER.'/save/'.$menu->getID(), Request::POST, 'editMenu');
			$this->form->addFormElement($name->getName(), $name);
			$this->form->addFormElement('save', $button);
		}

		return $this->form;
	}
	

	public function edit() {

		try {
			
			$menu = new Menu(Util::getUrlSegment(2));

			$view = new View(Conf::get('general.dir.templates') . '/menu/menuedit.php');
			$view->assign('errors', $this->session->get('errors'));
			$view->assign('form', $this->buildEditForm($menu));

			$this->session->set('errors', null);

			$baseView = parent::getBaseView();
			$baseView->assign('oModule', $view);
			
			return $baseView;

		} catch (RecordException $e) {
			$this->session->set('errors', array($e->getMessage()));
			$this->_redirect(self::CONTROLLER);
		}
	}

	public function save() {

		$data = $this->getConnection();
		$menu = new Menu(Util::getUrlSegment(2));

		$form = $this->buildEditForm($menu);
		$form->listen(Request::getInstance());

		$mapper = new FormMapper();
		$mapper->addFormElementToDomainEntityMapping('name', 'RequiredTextLine');

		try {

			$data->beginTransaction();

			$mapper->constructModelsFromForm($form);

			$menu->setName($mapper->getModel('name'));
			$menu->save();

			$data->commit();

			$this->_redirect(self::CONTROLLER);
			
		} catch (FormMapperException $e) {

			$data->rollBack();

			$this->session->set('errors', $mapper->getMappingErrors());
			return $this->edit();
		}
	}

	public function delete() {

		$data = $this->getConnection();
		try {

			$data->beginTransaction();

			$menu = new Menu(Util::getUrlSegment(2));
			$menu->delete();

			$data->commit();

		} catch (Exception $e) {

			$data->rollBack();
			$this->session->set('errors', array($e->getMessage()));
			
		}

		$this->_redirect(self::CONTROLLER);

	}

}
