<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\MailBuilder;
use Gos\Bundle\MailerBundle\Manager\Transport\Builder\MailBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Mail implements MailInterface
{
    private $options;

    public function finishView(array $options)
    {
        //stub implement if needed
        return [];
    }

    public function getName()
    {
        //stub implement if needed
        return '';
    }

    protected function buildMail(MailBuilderInterface $builder, array $options)
    {
        //stub implement if needed
    }

    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //stub implement if needed
    }

    protected function setOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([
            'template'
        ]);

        $resolver->setDefaults([
            'content_type' => 'text/html'
        ]);

        $resolver->setAllowedTypes([
            'content_type' => ['string'],
            'template' => ['string']
        ]);

        $this->setDefaultOptions($resolver);
    }

    public function getBuilder(array $options = [])
    {
        $optionsResolver = new OptionsResolver();

        $this->setOptions($optionsResolver);

        $this->options = $optionsResolver->resolve($options);

        $mailBuilder = new MailBuilder($this->options, $this->finishView($this->options));

        $this->buildMail($mailBuilder, $this->options);

        return $mailBuilder;
    }
}
