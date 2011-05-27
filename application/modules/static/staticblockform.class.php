<?php

class StaticBlockForm extends Form {

	/**
	 *
	 * @var StaticBlock
	 */
	private $block;

	/**
	 *
	 * @param Request $req
	 * @param StaticBlock $block
	 */
	public function __construct(Request $req, StaticBlock $block) {

		$this->block = $block;
		parent::__construct(Conf::get('general.cmsurl.www').'/staticblock/editblock/'.$block->getID(), Request::POST, 'blockform');

	}

	protected function defineFormElements() {

		$this->addFormElement(new Input('hidden', 'block_id', $this->block->getID()));
		$this->addFormElement(new Input('text', 'name', $this->block->getName()));
		$this->addFormElement(new Input('text', 'identifier', $this->block->getIdentifier()));
		$this->addFormElement(new TextArea('content', $this->block->getContent()));

	}

}