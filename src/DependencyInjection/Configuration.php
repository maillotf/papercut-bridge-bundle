<?php

namespace MaillotF\Papercut\PapercutBridgeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Description of Configuration
 *
 * @package MaillotF\Papercut\PapercutBridgeBundle\DependencyInjection
 * @author Flavien Maillot "contact@webcomputing.fr"
 */
class Configuration implements ConfigurationInterface
{
	/**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
		$builder = new TreeBuilder('papercut');

        $builder->getRootNode()->addDefaultsIfNotSet()
            ->children()
				->arrayNode('authentication')
                    ->isRequired()
                    ->children()
                        ->scalarNode('protocol')
//                            ->isRequired()
//                            ->cannotBeEmpty()
							->defaultValue(null)
                        ->end()
						->scalarNode('host')
//                            ->isRequired()
//                            ->cannotBeEmpty()
							->defaultValue(null)
                        ->end()
						->integerNode('port')
//                            ->isRequired()
                            ->defaultValue(null)
                        ->end()
						->scalarNode('path')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
						->scalarNode('token')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
					->end()
				->end()
			->end()
		;
		return ($builder);
	}
}
