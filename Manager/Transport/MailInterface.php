<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

interface MailInterface
{
    public function getBuilder(Array $options = array());

    public function getName();
}
