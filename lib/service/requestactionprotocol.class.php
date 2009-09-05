<?php

class RequestActionProtocol extends AbstractServiceProtocol
{

	public function execute()
	{
		$args = parent::getArguments();
		parent::setActionHandler($args['action']);
		parent::execute();
	}

	public function decode($newData)
	{
		parent::setArguments($newData);
	}

	public function encode()
	{
		return parent::getResult();
	}

	public function validate()
	{
		// check if request data is ok
		$args = parent::getArguments();
		if (!isset($args['initialAction']) && !isset($args['action']))
		{
			throw new ProtocolException('No action or initialAction defined');
		}

		$initial = false;
		if (!isset($args['action']))
		{
			$args['action'] = $args['initialAction'];
			$initial = true;
		}

		try
		{
			Util::validClass($args['action'].parent::SUFFIX);
		}
		catch (ClassException $e)
		{
			if ($initial)
			{
				throw new ProtocolException("ActionHandler cannot be found");
			}
				
			$args['action'] = $args['initialAction'];
			try
			{
				Util::validClass($args['action'].parent::SUFFIX);
			}
			catch(ClassException $e)
			{
				throw new ProtocolException("Initial ActionHandler cannot be found");
			}
		}

		parent::setArguments($args);
	}

	public function error($message)
	{
		echo $message;
	}
}


?>