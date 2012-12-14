<?php

namespace Dpn\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dpn_cms');

        $rootNode
            ->children()
                ->scalarNode('pages_dir')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
