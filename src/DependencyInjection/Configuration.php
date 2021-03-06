<?php

namespace MegaData\MegaDataBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mega_data');

        $rootNode
            ->children()
                ->scalarNode('api_url')->end()
                ->scalarNode('format')
                    ->defaultValue('json')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
