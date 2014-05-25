<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

use Gos\Bundle\MailerBundle\Manager\Transport\Builder\MailBuilder;
use Gos\Bundle\MailerBundle\Manager\Transport\Builder\MailBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Mail implements MailInterface
{
    private $options;

    public function finishView(Array $options)
    {
        //stub implement if needed
        return array();
    }

    public function getName()
    {
        //stub implement if needed
        return '';
    }

    protected function buildMail(MailBuilderInterface $builder, Array $options)
    {
        //stub implement if needed
    }

    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        //stub implement if needed
    }

    protected function setOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'template'
        ));

        $resolver->setDefaults(array(
            'content_type' => 'text/html'
        ));

        $resolver->setAllowedTypes(array(
            'content_type' => array('string'),
            'template' => array('string')
        ));

        $this->setDefaultOptions($resolver);
    }

    public function getBuilder(Array $options = array())
    {
        $optionsResolver = new OptionsResolver();

        $this->setOptions($optionsResolver);

        $this->options = $optionsResolver->resolve($options);

        $mailBuilder = new MailBuilder($this->options, $this->finishView($this->options));

        $this->buildMail($mailBuilder, $this->options);

        return $mailBuilder;
    }
}
