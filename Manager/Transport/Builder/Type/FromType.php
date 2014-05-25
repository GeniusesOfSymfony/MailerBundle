<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\BuilderMessageInterface;

class FromType extends AbstractType
{
    public function process(BuilderMessageInterface $message, $data)
    {
        $message->setFrom($data);
    }
}
