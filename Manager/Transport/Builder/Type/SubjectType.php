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

        $optionsResolver->setDefaults([
            'translation_domain' => null,
            'locale' => null,
            'parameters' => []
        ]);

        $optionsResolver->setAllowedTypes([
            'translation_domain' => ['string', 'null'],
            'locale' => ['string', 'null'],
            'parameters' => ['array']
        ]);

        $message->setSubject($data, $optionsResolver->resolve($this->options));
    }
}
