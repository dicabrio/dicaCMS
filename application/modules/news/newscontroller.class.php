<?php

class NewsController extends CmsController {
	
	const CONTROLLER = 'news';

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

		parent::__construct(self::CONTROLLER . '/' . $method, Lang::get('news.title'));
		$this->session = Session::getInstance();
	}

	/**
	 * @return View
	 */
	public function _index() {

		$news = News::findAll();

		$view = new View(Conf::get('general.dir.templates') . '/news/newsoverview.php');
		$view->assign('errors', $this->session->get('errors'));
		$view->assign('newsItems', $news);
		
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
	private function buildNewsEditForm(News $newsItem) {

		$typeSelector = new Select('type');
		$typeSelector->addOption(0, Lang::get('news.label.choose'));
		$typeSelector->addOption('news', Lang::get('news.label.news'));
		$typeSelector->addOption('agenda', Lang::get('news.label.agenda'));
		$typeSelector->setValue($newsItem->getType());

		$formElements = array(
			new Input('text', 'title', $newsItem->getTitle()),
			new Input('text', 'publishtime', $newsItem->getPublishTime()),
			new Input('text', 'expiretime', $newsItem->getExpireTime()),
			$typeSelector,
			new TextArea('summary', $newsItem->getSummary()),
			new TextArea('body', $newsItem->getBody()),
			new ActionButton('save'),
		);

		if ($this->form == null) {
			$this->form = new Form(Conf::get('general.cmsurl.www').'/'.self::CONTROLLER.'/save/'.$newsItem->getID(), Request::POST, 'editNews');

			foreach ($formElements as $element) {
				$this->form->addFormElement($element);
			}
		}

		return $this->form;
	}
	

	public function edit() {

		try {
			
			$tag = new News(Util::getUrlSegment(2));

			$view = new View(Conf::get('general.dir.templates') . '/news/editnews.php');
			$view->assign('errors', $this->session->get('errors'));
			$view->assign('form', $this->buildNewsEditForm($tag));

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
		$newsItem = new News(Util::getUrlSegment(2));

		$form = $this->buildNewsEditForm($newsItem);
		$form->listen(Request::getInstance());

		$mapper = new FormMapper();
		$mapper->addFormElementToDomainEntityMapping('type', 'RequiredTextLine');
		$mapper->addFormElementToDomainEntityMapping('title', 'RequiredTextLine');
		$mapper->addFormElementToDomainEntityMapping('publishtime', 'Date');
		$mapper->addFormElementToDomainEntityMapping('expiretime', 'Date');
		$mapper->addFormElementToDomainEntityMapping('summary', 'DomainText');
		$mapper->addFormElementToDomainEntityMapping('body', 'DomainText');

		try {

			$data->beginTransaction();

			$mapper->constructModelsFromForm($form);

			$newsItem->setType($mapper->getModel('type'));
			$newsItem->setTitle($mapper->getModel('title'));
			$newsItem->setPublishTime($mapper->getModel('publishtime'));
			$newsItem->setExpireTime($mapper->getModel('expiretime'));
			$newsItem->setSummary($mapper->getModel('summary'));
			$newsItem->setBody($mapper->getModel('body'));
			$newsItem->save();

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

			$newsItem = new News(Util::getUrlSegment(2));
			$newsItem->delete();

			$data->commit();

		} catch (Exception $e) {

			$data->rollBack();
			$this->session->set('errors', array($e->getMessage()));
			
		}

		$this->_redirect(self::CONTROLLER);

	}

}
