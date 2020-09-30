<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\Service;

use PhpXmlRpc;

/**
 * Abstract class AbstractPapercut
 *
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
abstract class AbstractPapercut
{

	/**
	 *
	 * @var PhpXmlRpc\Client 
	 */
	protected $client;

	/**
	 *
	 * @var string 
	 */
	protected $token;

	public function __construct(string $path,
			string $token,
			?string $protocol = null,
			?string $host = null,
			?int $port = null)
	{
		$this->token = $token;
		if ($protocol != null && $host != null && $port != null)
			$this->client = new PhpXmlRpc\Client($path, $host, $port, $protocol);
		else
			$this->client = new PhpXmlRpc\Client($path);
	}
	
	/**
	 * Request to the papercut server
	 * 
	 * @param string $name
	 * @param array $data
	 * @return string|array
	 * @author Flavien Maillot 
	 */
	protected function request(string $name, array $data)
	{
		array_unshift($data, new PhpXmlRpc\Value($this->token, 'string'));
		$message = new PhpXmlRpc\Request('api.' . $name, $data);
		$response = $this->client->send($message);

		if ($response->faultCode())
		{
			return 'ERROR: ' . $response->faultString();
		}
		else
		{
			return $response->value()->scalarval();
		}
	}

}
