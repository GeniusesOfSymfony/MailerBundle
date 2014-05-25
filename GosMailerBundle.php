<?php
namespace Gos\Bundle\MailerBundle;

use Gos\Bundle\MailerBundle\Manager\Transport\MailCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GosMailerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MailCompilerPass());
    }
}
