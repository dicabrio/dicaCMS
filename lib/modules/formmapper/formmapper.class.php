<?php

/**
 * FormMapper is a class that maps FormElements to DomainEntities
 * You specify the formelement name as a key and give DomainObject to map to.
 *
 * usage:
 *
 * $form = new Form(....);
 * $mapper = new FormMapper();
 * $mapper->addFormElementToDomainEntityMapping('name', 'DomainText');
 * try {
 * 		$mapper->constructModelsFromForm($form);
 * } catch (FormMapperException $e) {
 * 		print_r($mapper->getMappingErrors());
 * }
 *
 * @author robertcabri
 */
class FormMapper {

	/**
	 * @var Form
	 */
	private $form;
	/**
	 * @var array
	 */
	private $aConstructedModels = array();
	/**
	 * @var array
	 */
	private $aMappingErrors = array();
	/**
	 * @var array
	 */
	private $aFormElementsToDomainEntitiesMapping = array();

	/**
	 * Construct the formmapper. This method call the defineFormElementToDomainEntityMapping().
	 * This method can be overridden for the mapping definition
	 */
	public function __construct() {

		$this->defineFormElementToDomainEntityMapping();
	}

	/**
	 * setup rules for form to domainentities mapping
	 */
	protected function defineFormElementToDomainEntityMapping() {

	}

	/**
	 * @param string $sFormElementName
	 * @param string $entity
	 */
	public function addFormElementToDomainEntityMapping($sFormElementName, $entityWithParameters) {

		$entityInformation = explode(':', $entityWithParameters);
		$entity = $entityInformation[0];

		if (!class_exists($entity, true)) {
			throw new FormMapperException('The specified domain entity does not exist: ' . $entity);
		}

		$this->aFormElementsToDomainEntitiesMapping[$sFormElementName] = $entityWithParameters;
	}

	/**
	 *
	 * @param string $formElementName
	 * @param string $domainEntity
	 * @return DomainEntity
	 */
	private function constructModelFromFormElement($formElementName, $domainEntity) {

		$entityWithAdditinalParameters = explode(':', $domainEntity);
		$domainEntity = $entityWithAdditinalParameters[0]; //

		$formElement = $this->form->getFormElementByName($formElementName);

		if (is_array($formElement)) {
			$arguments = array($formElement);
		} else {
			$arguments = array($formElement->getValue());
		}

		if (count($entityWithAdditinalParameters) == 2) {
			$additionalParameters = explode(',', $entityWithAdditinalParameters[1]);
			$arguments = array_merge($arguments, $additionalParameters);
		}

		try {

			return $this->constructModel($domainEntity, $arguments);
		} catch (Exception $e) {

			$formElement->notMapped();
			$this->aMappingErrors[$formElementName] = $formElementName . '-' . $e->getMessage();

			return null;
		}
	}

	/**
	 *
	 * @param string $sClass
	 * @param array $aArguments
	 */
	private function constructModel($sClass, $aArguments) {
		if (!is_array($aArguments)) {
			trigger_error('$aArguments should be an array');
		}

		$oReflectionClass = new ReflectionClass($sClass);
		$domainEntity = $oReflectionClass->newInstanceArgs($aArguments);
		return $domainEntity;
	}

	/**
	 * @throws FormMapperException if there are errors while mapping formelements to domainentities
	 *
	 * @param Form $oForm
	 */
	public function constructModelsFromForm(Form $oForm) {

		$this->form = $oForm;

		foreach ($this->aFormElementsToDomainEntitiesMapping as $sFormElementName => $sDomainEntity) {
			$this->aConstructedModels[$sFormElementName] = $this->constructModelFromFormElement($sFormElementName, $sDomainEntity);
		}

		if ($this->hasErrors()) {
			throw new FormMapperException('Error while validating data in the models');
		}
	}

	/**
	 * @return boolean
	 */
	private function hasErrors() {
		return (count($this->aMappingErrors) > 0);
	}

	public function getMappingErrors() {
		return $this->aMappingErrors;
	}

	public function addMappingError($key, $errormsg) {
		$this->aMappingErrors[$key] = $errormsg;
	}

	/**
	 * get the constructed model. If the model was not constructed because the there was no mapping defined.
	 * It will return the raw value
	 *
	 * @param string $sFormElementIdentifier
	 * @return DomainEntity
	 */
	public function getModel($sFormElementIdentifier) {

		if (isset($this->aConstructedModels[$sFormElementIdentifier])) {
			return $this->aConstructedModels[$sFormElementIdentifier];
		}

		return $this->form->getFormElement($sFormElementIdentifier)->getValue();
	}

}

class FormMapperException extends Exception {

}