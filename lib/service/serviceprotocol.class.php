<?php

interface ServiceProtocol
{
	/**
	 * execute the handler
	 *
	 */
	public function execute();

	/**
	 * decode the data given from the service
	 *
	 * @param mixed $data
	 */
	public function decode($data);

	/**
	 * return the result in encoded format
	 * @return mixed
	 */
	public function encode();

	/**
	 * Validate the data given
	 *
	 * throws a ProtocolException if not correct
	 */
	public function validate();

	/**
	 * Echo error message
	 *
	 * @param string $message
	 */
	public function error($message);
}

?>