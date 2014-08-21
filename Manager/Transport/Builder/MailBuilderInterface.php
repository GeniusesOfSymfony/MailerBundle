<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

interface MailBuilderInterface
{
    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator);

    /**
     * @param       $type
     * @param       $data
     * @param array $options
     */
    public function add($type, $data, array $options = []);

    /**
     * @param EngineInterface $engine
     * @param                 $emailProvider
     *
     * @return mixed
     */
    public function render(EngineInterface $engine, $emailProvider);
}
