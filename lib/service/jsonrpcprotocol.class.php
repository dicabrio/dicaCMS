<?php


class JsonRpcProtocol implements ServiceProtocol
{
	private $data;

	public function decode($pData)
	{
		$this->data = $pData;
	}

	public function encode()
	{
		return json_encode($this->data);
	}

	public function execute()
	{
		$actionHandler = $this->data->actionHandler.'ActionHandler';
		$handler = new $actionHandler();
		if (!($handler instanceof ActionHandler))
		throw new ProtocolException('Not a valid handler');

		try
		{
			$this->data->result = $handler->execute($this->data->arguments);
		}
		catch (ActionHandlerException $e)
		{
			throw new ProtocolException($e->getMessage());
		}
	}

	/**
	 * Validate the data
	 * TODO: extend with some validation lib
	 *
	 */
	public function validate()
	{
		if (!isset($this->data->method) || $this->data->method == null)
		{
			throw new ProtocolException("No method specified", 32600);
		}

		if (!is_string($this->data->method))
		{
			throw new ProtocolException("Invalid request", 32600);
		}

		try
		{
			Util::validClass($this->data->method.'ActionHandler');
		}
		catch (ClassException $e)
		{
			throw new ProtocolException("Method can't be found", 32601);
		}
	}

	public function error($error)
	{
		// contruct object
		$this->data->error = $error;
		return $this->encode();
	}
}
?>