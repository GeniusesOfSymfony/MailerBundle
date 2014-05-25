<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class MailRegistry implements MailRegistryInterface
{
    protected $mails;

    public function __construct()
    {
        $this->mails = array();
    }

    public function addMail(MailInterface $mail)
    {
        $this->mails[$mail->getName()] = $mail;
    }

    public function getMail($mailName)
    {
        if (!isset($this->mails[$mailName])) {
            throw new ServiceNotFoundException($mailName);
        }

        return $this->mails[$mailName];
    }
}
