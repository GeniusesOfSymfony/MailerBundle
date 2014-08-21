<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

interface MailInterface
{
    /**
     * @return Builder\MailBuilder
     */
    public function getBuilder(array $options = []);

    /**
     * @return string
     */
    public function getName();
}
