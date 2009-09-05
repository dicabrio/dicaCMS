<?php

abstract class AbstractServiceProtocol implements ServiceProtocol
{
	private $result;

	private $arguments;

	private $actionHandler;

	const SUFFIX = "ActionHandler";

	public function setActionHandler($handlerName)
	{
		$this->actionHandler = $handlerName;
	}

	public function getActionHandler()
	{
		return $this->actionHandler;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function setArguments($data)
	{
		$this->arguments = $data;
	}

	public function getResult()
	{
		return $this->result;
	}

	public function execute()
	{

		try
		{
			$actionHandler = $this->actionHandler.self::SUFFIX;
			Util::validClass($actionHandler);
			$handler = new $actionHandler();
			if (!($handler instanceof ActionHandler))
			throw new ProtocolException('Not a valid handler');

			$this->result = $handler->execute($this->arguments);
		}
		catch (ActionHandlerException $e)
		{
			throw new ProtocolException($e->getMessage());
		}
		catch (ClassException $ce)
		{
			throw new ProtocolException($ce->getMessage());
		}
	}


}

?>