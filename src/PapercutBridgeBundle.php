<?php

namespace MaillotF\Papercut\PapercutBridgeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use MaillotF\Papercut\PapercutBridgeBundle\DependencyInjection\PapercutExtension;

/**
 * Class PapercutBridgeBundle
 *
 * @package MaillotF\Papercut\PapercutBridgeBundle
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class PapercutBridgeBundle extends Bundle
{
	public function getContainerExtension()
	{
		return new PapercutExtension();
	}
}
