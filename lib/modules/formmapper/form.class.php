<?php
/**
 * The Form
 *
 * @author robertcabri
 */
class Form {

	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var string
	 */
	private $sFormMethod;
	/**
	 * @var string
	 */
	private $sFormAction;
	/**
	 * @var string
	 */
	private $formIdentifier;
	/**
	 * @var string
	 */
	private $sFormEnctype;
	/**
	 * @var array
	 */
	private $aFormElementsByIdentifier = array();
	/**
	 * @var array
	 */
	private $aSubmitButtonsAndHandlers = array();
	/**
	 * @var array
	 */
	private $aFormElementsByName = array();
	
	/**
	 * @var FormElement
	 */
	private $pressedButton;

	/**
	 * @param string $sAction
	 * @param string $sMethod
	 * @param string $sIdentifier
	 */
	public function __construct($sAction, $sMethod='post', $sIdentifier=null) {

		$this->sFormAction = $sAction;
		$this->sFormMethod = $sMethod;
		$this->formIdentifier = $sIdentifier;

		$this->defineFormElements();
	}

	/**
	 * In this method you should define the form. This is done to force you adding elements
	 */
	protected function defineFormElements() {

	}

	/**
	 * This method will get a value from a request. It checks if the request object exists
	 * IF not it returns null
	 *
	 * @param string $sRequestKey
	 * @return mixed
	 */
	private function getValueFromRequest(FormElement $formElement) {

		if ($this->isSubmitted()) {
			$formElementName = $formElement->getName();

			$formElementType = $formElement->getType();
			if ($formElementType == 'file') {
				return $this->request->files($formElementName);
			} else {
				$requestValue = $this->request->request($formElementName);
				return $requestValue;
			}
		}
	}

	/**
	 * this method is only allowed to be called in the defineFormElements method
	 *
	 * @param FormElement $formElement
	 */
	public function addFormElement(FormElement $formElement, FormHandler $handler = null) {

		$formElementIdentifier = $formElement->getIdentifier();

		if ($formElement->getType() == 'file') {
			$this->sFormEnctype = ' enctype="multipart/form-data"';
		}

		if ($this->isSubmitted() && $formElement->getType() !== 'submit') {
			$formElement->setValue($this->getValueFromRequest($formElement));
		}

		$this->aFormElementsByIdentifier[$formElementIdentifier] = $formElement;
		$this->aFormElementsByName[$formElement->getName()][] = $formElement;

		if ($handler !== null) {
			$this->aSubmitButtonsAndHandlers[$formElementIdentifier] = array('FormElement' => $formElement, 'FormHandler' => $handler);
		}
	}

	/**
	 * @param string $sFormElementIdentifier
	 * @return FormElement
	 */
	public function getFormElement($sFormElementIdentifier) {

		if (!isset($this->aFormElementsByIdentifier[$sFormElementIdentifier])) {
			throw new FormException('requested form element is not defined in this form: ' . $sFormElementIdentifier);
		}

		return $this->aFormElementsByIdentifier[$sFormElementIdentifier];
	}

	/**
	 * @return array
	 */
	public function getFormElements() {

		return $this->aFormElementsByIdentifier;
	}

	/**
	 *
	 * @param string $sFormElementName
	 * @return FormElement
	 */
	public function getFormElementByName($sFormElementName) {

		if (!isset($this->aFormElementsByName[$sFormElementName])) {
			throw new FormException('No such elementname defined: ' . $sFormElementName);
		}

		$aElements = $this->aFormElementsByName[$sFormElementName];
		if (!is_array($aElements) || count($aElements) == 0) {
			throw new FormException('No such elements for this elementname defined: ' . $sFormElementName);
		}

		if (count($aElements) == 1) {
			return current($aElements);
		}

		// is it a redio button or a checkbox.. they have other behaviour
		$firstElementCheck = reset($aElements);
		if ($firstElementCheck->getType() == 'radio') {
			foreach ($aElements as $oFormElement) {
				if ($oFormElement->isSelected()) {
					return $oFormElement;
				}
			}
		} else {
			// it's a checkbox
			return $aElements;
		}
	}

	/**
	 * @return string
	 */
	public function getFormAction() {

		return $this->sFormAction;
	}

	public function addListener($buttonIdentifier, FormHandler $handler) {

		$formElement = $this->getFormElement($buttonIdentifier);
		$this->addSubmitButton($formElement, $handler);
	}

	/**
	 * @param string $sButtonIdentifier
	 * @param FormElement $oElement
	 * @param FormHandler $oHandler
	 */
	public function addSubmitButton(FormElement $oElement, FormHandler $oHandler) {

		$this->aSubmitButtonsAndHandlers[$oElement->getIdentifier()] = array('FormElement' => $oElement, 'FormHandler' => $oHandler);
	}

	/**
	 * @param string $sButtonIdentifier
	 * @return FormElement
	 */
	public function getSubmitButton($sButtonIdentifier) {

		if (isset($this->aSubmitButtonsAndHandlers[$sButtonIdentifier])) {
			return $this->aSubmitButtonsAndHandlers[$sButtonIdentifier]['FormElement'];
		}
		return null;
	}

	/**
	 * Listen if the form is submitted. It will tell the handlers to fire if the right button is pressed
	 */
	public function listen(Request $request) {

		$this->request = $request;

		if ($this->isSubmitted()) {
			$this->populateFormElementsWithRequestData();
		}


		foreach ($this->aSubmitButtonsAndHandlers as $aSingleSubmitButtonAndHandler) {
			$oButton = $aSingleSubmitButtonAndHandler['FormElement'];
			$oHandler = $aSingleSubmitButtonAndHandler['FormHandler'];
			$sValueFromRequest = $this->getValueFromRequest($oButton);
			if ($sValueFromRequest == $oButton->getValue()) {
				$this->pressedButton = $oButton;
				$oHandler->handleForm($this);
			}
		}
	}
	
	public function getPressedButton() {
		return $this->pressedButton;
	}

	/**
	 * @return void
	 */
	private function populateFormElementsWithRequestData() {

		foreach ($this->aFormElementsByIdentifier as $oFormElement) {
			if ($oFormElement->getType() !== 'submit') {
				$oFormElement->setValue($this->getValueFromRequest($oFormElement));
			}
		}
	}

	/**
	 * @return string
	 */
	public function begin() {

		return '<form id="' . $this->formIdentifier . '" method="' . $this->sFormMethod . '" action="' . $this->sFormAction . '"' . $this->sFormEnctype . '>';
	}

	/**
	 * @return sring
	 */
	public function end() {

		return '</form>';
	}

	/**
	 * @return string
	 */
	public function getIdentifier() {

		return $this->formIdentifier;
	}

	/**
	 * check if this form is submitted
	 * @return Boolean
	 */
	public function isSubmitted() {

		if ($this->request instanceof Request) {
			return ($this->request->method() == Request::POST);
		}

		return false;
	}

}

class FormException extends Exception {

}