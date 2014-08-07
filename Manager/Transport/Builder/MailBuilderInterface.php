<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Templating\EngineInterface;

interface MailBuilderInterface
{
    /**
     * @return void
     */
    public function setTranslator(Translator $translator);

    /**
     * @param string $type
     * @param string $data
     *
     * @return void
     */
    public function add($type, $data, Array $options = array());

    /**
     * @return \Swift_Message
     */
    public function render(EngineInterface $engine, $emailProvider);
}
