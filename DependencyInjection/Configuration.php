<?php
namespace Gos\Bundle\MailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('gos_mailer');
        $rootNode->children()
            ->arrayNode('services')
                ->requiresAtLeastOneElement()
                    ->prototype('scalar')->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
