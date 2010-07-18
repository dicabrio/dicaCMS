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
	 * construct the imageupload module
	 *
	 * @param PageModule $oMod
	 * @param Form $form
	 * @param FormMapper $mapper
	 * @param CmsController $oCmsController
	 *
	 * @return void
	 */
	public function __construct(PageModule $oMod, Form $form, FormMapper $mapper, CmsController $oCmsController=null) {

		$this->oPageModule = $oMod;
		$this->form = $form;
		$this->mapper = $mapper;

		// load the data
		$this->load();
	}

	private function load() {

		$this->oTextContent = PageText::getByPageModule($this->oPageModule);
		
		$contentFormElement = new Input('text', $this->oPageModule->getIdentifier(), $this->oTextContent->getContent());
		$this->form->addFormElement($contentFormElement->getName(), $contentFormElement);
		$this->mapper->addFormElementToDomainEntityMapping($contentFormElement->getName(), 'PriceListXML');

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