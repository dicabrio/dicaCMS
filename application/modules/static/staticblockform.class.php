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

		$blockid = new Input('hidden', 'block_id', $this->block->getID());
		$this->addFormElement($blockid);

		$blockidentifier = new Input('text', 'identifier', $this->block->getIdentifier());
		$this->addFormElement($blockidentifier);

		$blockcontent = new TextArea('content', $this->block->getContent());
		$this->addFormElement($blockcontent);

	}

}