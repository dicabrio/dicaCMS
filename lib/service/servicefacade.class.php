<?php
/**
 * Static class will catch the requests and processes it
 * This is a service for ajax driven apps.
 *
 */
class ServiceFacade {

	/**
	 * @var ServiceProtocol
	 */
	private $protocol = null;

	public function __construct(ServiceProtocol $protocol) {
		$this->protocol = $protocol;
	}

	/**
	 * just follow protocol
	 *
	 * @param string $requestString
	 * @param string $protocol
	 * @return string
	 */
	public function execute($reqData) {
		if ($this->protocol == null) {
			throw new ServiceFacadeException('Service Handler is not set');
		}

		try {
			$prot = $this->protocol;
			$prot->decode($reqData);
			$prot->validate();
			$prot->execute();
			return $prot->encode();
		} catch(ProtocolException $e) {
			return $prot->error($e);
		}
	}
}

