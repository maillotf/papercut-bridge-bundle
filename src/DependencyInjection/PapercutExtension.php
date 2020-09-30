<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class PapercutExtension
 *
 * @package MaillotF\Papercut\PapercutBridgeBundle\DependencyInjection
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class PapercutExtension extends Extension
{
	public function load(array $configs, ContainerBuilder $container)
	{
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
		
		// Authentication
		$container->setParameter('papercut.authentication.protocol', $config['authentication']['protocol']);
		$container->setParameter('papercut.authentication.host', $config['authentication']['host']);
		$container->setParameter('papercut.authentication.port', $config['authentication']['port']);
		$container->setParameter('papercut.authentication.path', $config['authentication']['path']);
		$container->setParameter('papercut.authentication.token', $config['authentication']['token']);

		// load services for bundle
		$loader = new YamlFileLoader(
				$container,
				new FileLocator(__DIR__ . '/../Resources/config')
		);
		$loader->load('services.yml');
	}
}
