<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

class MailFactory
{
    protected $mailRegistry;

    public function __construct(MailRegistryInterface $mailRegistry)
    {
        $this->mailRegistry = $mailRegistry;
    }

    /**
     * @param string $mailName
     *
     * @return MailInterface
     */
    public function createNamed($mailName)
    {
        return $this->mailRegistry->getMail($mailName);
    }
}
