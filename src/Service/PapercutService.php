<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\Service;

/**
 * Class PapercutService
 *
 * @package MaillotF\Papercut\PapercutBridgeBundle\Service
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class PapercutService implements PapercutServiceInterface
{

	/**
	 *
	 * @var \MaillotF\Papercut\PapercutBridgeBundle\Service\UserService
	 */
	public $user;
	
	public function __construct(
			string $path,
			string $token,
			?string $protocol = null,
			?string $host = null,
			?int $port = null
	)
	{
		$this->user = new UserService($path, $token, $protocol, $host, $port);
	}
	
	/**
	 * 
	 * @return \MaillotF\Papercut\PapercutBridgeBundle\Service\UserService
	 * @author Flavien Maillot 
	 */
	public function getUserService(): UserService
	{
		return ($this->user);
	}
	
}
