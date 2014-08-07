<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder\Type;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\BuilderMessageInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
{
    /**
     * @param string $data
     */
    public function process(BuilderMessageInterface $message, $data)
    {
        $optionsResolver = new OptionsResolver($this->options);

        $optionsResolver->setDefaults(array(
            'translation_domain' => null,
            'locale' => null,
            'parameters' => array()
        ));

        $optionsResolver->setAllowedTypes(array(
            'translation_domain' => array('string', 'null'),
            'locale' => array('string', 'null'),
            'parameters' => array('array')
        ));

        $message->setSubject($data, $optionsResolver->resolve($this->options));
    }
}
