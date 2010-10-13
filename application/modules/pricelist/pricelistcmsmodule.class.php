<?php

class PricelistCmsModule implements CmsModuleController {

	const MAX_LENGTH = 255;

	/**
	 * @var PageModule
	 */
	private $oPageModule;

	/**
	 * @var PageText
	 */
	private $oTextContent;

	/**
	 * @var Form
	 */
	private $form;

	/**
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 * @var FormElement
	 */
	private $contentFormElement;

	/**
	 * construct the imageupload module
	 *
	 * @param PageModule $oMod
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form) {

		$this->oPageModule = $oMod;
		$this->form = $form;

		// load the data
		$this->load();
	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		
		$this->contentFormElement = new Input('text', $this->oPageModule->getIdentifier(), $this->oTextContent->getContent());
		$this->form->addFormElement($this->contentFormElement->getName(), $this->contentFormElement);

	}

	public function addFormMapping(FormMapper $mapper) {

		$this->mapper = $mapper;
		$this->mapper->addFormElementToDomainEntityMapping($this->contentFormElement->getName(), 'PriceListXML');
		
	}


	/**
	 * (non-PHPdoc)
	 * @see modules/Module#getEditor()
	 */
	public function getEditor() {

		$oView = new View('pricelist/pricelistfeed.php');
		$oView->sMaxLength = self::MAX_LENGTH;
		$oView->sIdentifier = $this->oPageModule->getIdentifier();
		$oView->form = $this->form;
		
		return $oView;
	}

	/**
	 *
	 * @param $oReq
	 * @return boolean
	 */
	public function handleData() {

		$sModIdentifier = $this->oPageModule->getIdentifier();
		$xmlGetter = $this->mapper->getModel($sModIdentifier);

		$feed = new XMLFeed();
		$feed->setXML($xmlGetter);
		$feed->setPageModule($this->oPageModule);
		$feed->save();

		return true;
	}

	/**
	 *
	 * @return string
	 */
	public function getIdentifier() {

		return $this->oPageModule->getIdentifier();
	}
}