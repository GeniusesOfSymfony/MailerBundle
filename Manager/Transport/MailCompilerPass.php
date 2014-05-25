<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MailCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('gos.mailer_bundle.mail.registry')) {
            return;
        }

        $definition = $container->getDefinition('gos.mailer_bundle.mail.registry');

        $taggedServices = $container->findTaggedServiceIds('mail');

        foreach ($taggedServices as $id => $taggedAttributes) {
            $definition->addMethodCall('addMail', array(new Reference($id)));
        }
    }
}
