<?php
class KeyNotFoundException extends Exception {}
class Collection
{
	private $members = array();

	public function __construct($initMembers=array())
	{
		$this->members = $initMembers;
	}

	public function set($key, $value)
	{
		if ($key==null)
		{
			$this->members[] = $value;
			return key($this->members);
		}
		else
		{
			$this->members[$key] = $value;
		}
	}

	/**
	 * TODO create a real collection object. Objects should also be a key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ($key == null || is_object($key)) {
			throw new InvalidArgumentException('No valid key given');
		}

		if (!isset($this->members[$key])) {
			throw new KeyNotFoundException('No value for this key');
		}

		return $this->members[$key];
	}

	public function remove($key)
	{
		if ($key == null) {
			throw new InvalidArgumentException('No key given');
		}

		if (!isset($this->members[$key])) {
			throw new KeyNotFoundException('Value cannot be removed with this key');
		}
			
		unset($this->members[$key]);
	}

	public function isPresent($key) {

		if ($key == null) {
			throw new InvalidArgumentException('No key given');
		}

		return isset($this->members[$key]);
	}

	public function toArray()
	{
		return $this->members;
	}

	public function size()
	{
		return count($this->members);
	}

	public function addAll(Collection $c) {
		$this->members = array_merge($this->members, $c->toArray());
	}
}



?>