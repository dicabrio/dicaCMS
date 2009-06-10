<?php
/**
 * Static class will catch the requests and processes it
 * This is a service for ajax driven apps.
 *
 */
class ServiceFacade
{
	private static $protocol = null;

	public static function setProtocol(ServiceProtocol $protocol)
	{
		//echo'test';
		self::$protocol = $protocol;
	}

	/**
	 * just follow protocol
	 *
	 * @param string $requestString
	 * @param string $protocol
	 * @return string
	 */
	public static function request($reqData)
	{
		if (self::$protocol == null) {
			throw new ServiceFacadeException('Service Handler is not set');
		}
		
		try
		{
			$prot = self::$protocol;
			$prot->decode($reqData);
			$prot->validate();
			$prot->execute();
			return $prot->encode();
		}
		catch(ProtocolException $e)
		{
			return $prot->error($e);
		}
	}

}

