<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\BuilderMessageInterface;

class ToType extends AbstractType
{
    public function process(BuilderMessageInterface $message, $data)
    {
        $message->setTo($data);
    }
}
