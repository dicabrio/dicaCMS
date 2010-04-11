<?php


class StaticBlockHandler implements FormHandler {

	/**
	 *
	 * @var FormMapper
	 */
	private $mapper;

	/**
	 * @var StaticBlock
	 */
	private $block;

	/**
	 * @param StaticBlock $block
	 * @param FormMapper $mapper
	 */
	public function __construct(StaticBlock $block, FormMapper $mapper) {
		$this->mapper = $mapper;
		$this->block = $block;
	}

	public function handleForm(Form $form) {

		try {
			$data = DataFactory::getInstance();
			$data->beginTransaction();

			$this->mapper->constructModelsFromForm($form);

			$this->block->update($this->mapper->getModel('identifier'), $this->mapper->getModel('content'), Conf::get('upload.dir.templates'));
			$this->block->save();

			$data->commit();
			Util::gotoPage(Conf::get('general.url.www').'/staticblock/');

		} catch (FormMapperException $e) {

		}

		$data->rollBack();
	}
}