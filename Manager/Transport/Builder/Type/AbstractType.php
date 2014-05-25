<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\BuilderMessageInterface;

class AbstractType
{
    protected $options;

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function process(BuilderMessageInterface $message, $data)
    {

    }
}
