<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Component\Translation\Translator;

interface BuilderMessageInterface
{
    public function setFrom($from);

    public function setTranslator(Translator $translator);

    public function addFrom($email, $name = null);

    public function render($emailService);

    public function getForm();

    public function setSubject($subject, Array $options = array());

    public function renderSubject();

    public function setTo($to);

    public function addTo($email, $name = null);
}
