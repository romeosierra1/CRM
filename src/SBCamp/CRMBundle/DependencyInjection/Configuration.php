<?php

namespace SBCamp\CRMBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('crm');
        $rootNode
            ->children()
                ->integerNode('global')->end()
                ->integerNode('text')->end()
                ->integerNode('double')->end()
                ->integerNode('date')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}