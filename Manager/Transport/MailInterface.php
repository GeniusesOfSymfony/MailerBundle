<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

interface MailInterface
{
    /**
     * @return Builder\MailBuilder
     */
    public function getBuilder(Array $options = array());

    /**
     * @return string
     */
    public function getName();
}
