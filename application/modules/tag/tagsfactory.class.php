<?php

class TagsFactory implements DomainEntity {
	
	/**
	 *
	 * @var array
	 */
	private $tags = array();

	/**
	 * 
	 * @param array $tags
	 */
	public function __construct($tags) {
		
		foreach ($tags as $tagCheckbox) {
			try {
				
				if ($tagCheckbox->isChecked()) {
					$tag = Tag::findByName($tagCheckbox->getValue());
					$this->tags[] = $tag;
				}
			} 
			catch (PDOException $e) {
				
			}
		}
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getTags() {
		
		return $this->tags;
	}
	
	/**
	 * 
	 * @return system
	 */
	public function __toString() {
		return __CLASS__;
	}

	/**
	 * 
	 * @param mixed $object
	 * @return boolean
	 */
	public function equals($object) {

		if ($object === null) {
			return false;
		}

		if (!is_a($object, get_class($this))) {
			return false;
		}

		return true;
	}

}