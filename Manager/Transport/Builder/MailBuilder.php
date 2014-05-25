<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Templating\EngineInterface;

class MailBuilder implements MailBuilderInterface
{
    protected $builderMessage;
    protected $factoryType;
    protected $options;
    protected $templateData;
    protected $tranlsator;
    protected $subjectParameters;

    public function __construct(Array $options, Array $templateData = array())
    {
        $this->options = $options;
        $this->builderMessage = new BuilderMessage();
        $this->factoryType = new FactoryType($this->options);
        $this->templateData = $templateData;
    }

    public function setTranslator(Translator $translator)
    {
        $this->tranlsator = $translator;
    }

    public function add($type, $data, Array $options = array())
    {
        $type = $this->factoryType->createType($type, $options);
        $type->process($this->builderMessage, $data);
    }

    public function render(EngineInterface $engine, $emailServices)
    {
        $this->builderMessage->setTranslator($this->tranlsator);

        $swiftMessage = $this->builderMessage->render($emailServices);
        $swiftMessage->setBody($engine->render($this->options['template'], $this->templateData));
        $swiftMessage->setContentType($this->options['content_type']);

        return $swiftMessage;
    }
}
