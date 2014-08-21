<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailBuilder implements MailBuilderInterface
{
    /**
     * @var BuilderMessage
     */
    protected $builderMessage;

    /**
     * @var FactoryType
     */
    protected $factoryType;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $templateData;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var array
     */
    protected $subjectParameters;

    /**
     * @param array $options
     * @param array $templateData
     */
    public function __construct(array $options, array $templateData = [])
    {
        $this->options = $options;
        $this->builderMessage = new BuilderMessage();
        $this->factoryType = new FactoryType($this->options);
        $this->templateData = $templateData;
    }

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->tranlsator = $translator;
    }

    /**
     * @param string $type
     * @param string $data
     * @param array  $options
     */
    public function add($type, $data, array $options = [])
    {
        $type = $this->factoryType->createType($type, $options);
        $type->process($this->builderMessage, $data);
    }

    /**
     * @param EngineInterface $engine
     * @param                 $emailServices
     *
     * @return \Swift_Message
     */
    public function render(EngineInterface $engine, $emailServices)
    {
        $this->builderMessage->setTranslator($this->translator);

        $swiftMessage = $this->builderMessage->render($emailServices);
        $swiftMessage->setBody($engine->render($this->options['template'], $this->templateData));
        $swiftMessage->setContentType($this->options['content_type']);

        return $swiftMessage;
    }
}
