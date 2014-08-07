<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

interface MailRegistryInterface
{
    /**
     * @return void
     */
    public function addMail(MailInterface $formHandler);

    /**
     * @param string $handlerName
     */
    public function getMail($handlerName);
}
