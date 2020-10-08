<?php

namespace SBCamp\ElasticSearchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elastic_search');
        $rootNode
            ->children()
            ->arrayNode('servers')
            ->children()
            ->arrayNode('server')
            ->children()
            ->scalarNode('host')->end()
            ->integerNode('port')->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}