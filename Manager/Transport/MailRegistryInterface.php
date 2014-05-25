<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

interface MailRegistryInterface
{
    public function addMail(MailInterface $formHandler);

    public function getMail($handlerName);
}
