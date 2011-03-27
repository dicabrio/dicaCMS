<?php

class TagController extends CmsController {
	
	const CONTROLLER = 'tag';

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

		parent::__construct(self::CONTROLLER . '/' . $method, Lang::get('tag.title'));
		$this->session = Session::getInstance();
	}

	/**
	 * @return View
	 */
	public function _index() {

		$tags = Tag::findAll();

		$view = new View(Conf::get('general.dir.templates') . '/tag/tagoverview.php');
		$view->assign('errors', $this->session->get('errors'));
		$view->assign('tags', $tags);
		
		$this->session->set('errors', null);

		$baseView = parent::getBaseView();
		$baseView->assign('oModule', $view);

		return $baseView;
	}

	public function _default() {
		return 'Not implemented yet!';
	}

	/**
	 * @return Form
	 */
	private function buildTagEditForm(Tag $tag) {

		$name = new Input('text', 'name', $tag->getName());
		$button = new ActionButton('save');

		if ($this->form == null) {
			$this->form = new Form(Conf::get('general.cmsurl.www').'/'.self::CONTROLLER.'/save/'.$tag->getID(), Request::POST, 'editTag');
			$this->form->addFormElement($name);
			$this->form->addFormElement($button);
		}

		return $this->form;
	}
	

	public function edit() {

		try {
			
			$tag = new Tag(Util::getUrlSegment(2));

			$view = new View(Conf::get('general.dir.templates') . '/tag/edittag.php');
			$view->assign('errors', $this->session->get('errors'));
			$view->assign('form', $this->buildTagEditForm($tag));

			$this->session->set('errors', null);

			$baseView = parent::getBaseView();
			$baseView->assign('oModule', $view);
			
			return $baseView;

		} catch (RecordException $e) {
			$this->session->set('errors', array('record-not-found'));
			$this->_redirect(self::CONTROLLER);
		}
	}

	public function save() {

		$data = DataFactory::getInstance();
		$tag = new Tag(Util::getUrlSegment(2));

		$form = $this->buildTagEditForm($tag);
		$form->listen(Request::getInstance());

		$mapper = new FormMapper();
		$mapper->addFormElementToDomainEntityMapping('name', 'TagName');

		try {

			$data->beginTransaction();

			$mapper->constructModelsFromForm($form);

			$tag->setName($mapper->getModel('name'));
			$tag->save();

			$data->commit();

			$this->_redirect(self::CONTROLLER);
		} catch (FormMapperException $e) {

			$data->rollBack();

			$this->session->set('errors', $mapper->getMappingErrors());
			return $this->edit();
		}
	}

	public function delete() {

		$data = DataFactory::getInstance();
		try {

			$data->beginTransaction();

			$tag = new Tag(Util::getUrlSegment(2));
			$tag->delete();

			$data->commit();

		} catch (Exception $e) {

			$data->rollBack();
			$this->session->set('errors', array($e->getMessage()));
			
		}

		$this->_redirect(self::CONTROLLER);

	}

}
