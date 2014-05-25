<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Templating\EngineInterface;

interface MailBuilderInterface
{
    public function setTranslator(Translator $translator);

    public function add($type, $data, Array $options = array());

    public function render(EngineInterface $engine, $emailProvider);
}
