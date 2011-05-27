<?php

class ProductController extends CmsController {
	const CONTROLLER = 'product';

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

		parent::__construct(self::CONTROLLER . '/' . $method, Lang::get('product.title'));
		$this->session = Session::getInstance();
	}

	/**
	 * @return View
	 */
	public function _index() {

		$news = Product::findAll();

		$view = new View(Conf::get('general.dir.templates') . '/product/productoverview.php');
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
	private function buildProductEditForm(Product $productItem) {

		$types = Lang::get('product.types');
		$typeSelector = new Select('type');
		$typeSelector->addOption(0, Lang::get('product.label.choose'));
		foreach ($types as $key => $name) {
			$typeSelector->addOption($key, $name);
		}
		$typeSelector->setValue($productItem->getType());

		$formElements = array(
			new Input('file', 'image'),
			new Input('file', 'detailimage'),
			new Input('text', 'title', $productItem->getTitle()),
			new Input('text', 'price', $productItem->getPrice()),
			new Input('text', 'publishtime', $productItem->getPublishTime()),
			new Input('text', 'expiretime', $productItem->getExpireTime()),
			$typeSelector,
			new TextArea('summary', $productItem->getSummary()),
			new TextArea('body', $productItem->getBody()),
			new ActionButton('save'),
		);

		if ($this->form == null) {
			$this->form = new Form(Conf::get('general.cmsurl.www') . '/' . self::CONTROLLER . '/save/' . $productItem->getID(), Request::POST, 'editProduct');

			foreach ($formElements as $element) {
				$this->form->addFormElement($element);
			}
		}

		return $this->form;
	}

	public function edit() {

		try {

			$product = new Product(Util::getUrlSegment(2));

			try {
				$image = $product->getImage();
				$detailImage = $product->getDetailImage();

				$imageFilename = $image->getFile()->getFilename();
				$detailImageFilename = $detailImage->getFile()->getFilename();
			} catch (Exception $e) {
				$imageFilename = '';
				$detailImageFilename = '';
			}

			$view = new View(Conf::get('general.dir.templates') . '/product/editproduct.php');
			$view->assign('errors', $this->session->get('errors'));
			$view->assign('form', $this->buildProductEditForm($product));
			$view->assign('productimage', $imageFilename);
			$view->assign('productdetailimage', $detailImageFilename);

			$this->session->set('errors', null);

			$baseView = parent::getBaseView();
			$baseView->assign('oModule', $view);

			return $baseView;
		} catch (RecordException $e) {
			$this->session->set('errors', array('record-not-found'));
			$this->_redirect(self::CONTROLLER);
		}
	}

	private function uploadFile(Upload $upload, $media, $title, $description) {

		$upload->moveTo(Conf::get('upload.dir.general'));
		$file = $upload->getFile();

		if ($file !== null) {
			$media->update(new RequiredTextLine($title), new RequiredTextLine($description), $file);
			$media->save();
		}
	}

	public function save() {

		$data = DataFactory::getInstance();
		$productItem = new Product(Util::getUrlSegment(2));

		$form = $this->buildProductEditForm($productItem);
		$form->listen(Request::getInstance());

		$mapper = new FormMapper();
		$mapper->addFormElementToDomainEntityMapping('type', 'RequiredTextLine');
		$mapper->addFormElementToDomainEntityMapping('title', 'RequiredTextLine');
		$mapper->addFormElementToDomainEntityMapping('price', 'RequiredTextLine');
		$mapper->addFormElementToDomainEntityMapping('publishtime', 'Date');
		$mapper->addFormElementToDomainEntityMapping('expiretime', 'Date');
		$mapper->addFormElementToDomainEntityMapping('summary', 'DomainText');
		$mapper->addFormElementToDomainEntityMapping('body', 'DomainText');
		$mapper->addFormElementToDomainEntityMapping('image', 'Upload');
		$mapper->addFormElementToDomainEntityMapping('detailimage', 'Upload');

		try {

			$data->beginTransaction();

			$mapper->constructModelsFromForm($form);

			$title = $mapper->getModel("title");
			$description = $mapper->getModel("summary");
			$uploadImage = $mapper->getModel('image');
			$uploadDetailImage = $mapper->getModel('detailimage');

			// alway add a new media file. Some other module may depend on the old media files
			$image = new Media();
			$detailImage = new Media();

			$this->uploadFile($uploadImage, $image, "normal: ".$title, $description);
			$this->uploadFile($uploadDetailImage, $detailImage, "Detail: ".$title, $description);

			$productItem->setType($mapper->getModel('type'));
			$productItem->setTitle($mapper->getModel('title'));
			$productItem->setPrice($mapper->getModel('price'));
			$productItem->setPublishTime($mapper->getModel('publishtime'));
			$productItem->setExpireTime($mapper->getModel('expiretime'));
			$productItem->setSummary($mapper->getModel('summary'));
			$productItem->setBody($mapper->getModel('body'));
			$productItem->setImage($image);
			$productItem->setDetailImage($detailImage);
			$productItem->save();

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

			$productItem = new Product(Util::getUrlSegment(2));
			$productItem->delete();

			$data->commit();
		} catch (Exception $e) {

			$data->rollBack();
			$this->session->set('errors', array($e->getMessage()));
		}

		$this->_redirect(self::CONTROLLER);
	}

}
