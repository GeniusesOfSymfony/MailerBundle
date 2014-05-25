<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Component\Translation\Translator;

class BuilderMessage implements BuilderMessageInterface
{
    protected $subject;
    protected $from = array();
    protected $to = array();
    protected $translator;
    protected $renderOptions;

    public function setFrom($from)
    {
        if (is_array($from)) {
            foreach ($from as $email => $name) {
                $this->addFrom($email, $name);
            }
        } else {
            $this->addFrom($from);
        }
    }

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function addFrom($email, $name = null)
    {
        if (null !== $name || is_integer($email)) {
            $this->from[$email] = $name;
        } else {
            $this->from[] = $email;
        }
    }

    protected function renderTo($emailService)
    {
        return $this->to;
    }

    protected function renderFrom($emailService)
    {
        $buffer = array();
        foreach ($this->from as $email => $name) {

            if (isset($emailService[$email])) {
                $buffer[$emailService[$email]] = $name;
            }

            if (isset($emailService[$name])) {
                $buffer[$email] = $emailService[$name];
            }
        }

        return $buffer;
    }

    public function render($emailService)
    {
        $message = \Swift_Message::newInstance();

        $message->setTo($this->renderTo($emailService));
        $message->setFrom($this->renderFrom($emailService));
        $message->setSubject($this->renderSubject());

        return $message;
    }

    public function getForm()
    {
        return $this->from;
    }

    public function setSubject($subject, Array $options = array())
    {
        $this->renderOptions['subject'] = $options;
        $this->subject = $subject;
    }

    public function renderSubject()
    {
        if (isset($this->renderOptions['subject'])) {
            $options = $this->renderOptions['subject'];

            return $this->translator->trans($this->subject, $options['parameters'], $options['translation_domain'], $options['locale']);
        }

        return $this->subject;
    }

    public function setTo($to)
    {
        if (is_array($to)) {
            foreach ($to as $email => $name) {
                $this->addTo($email, $name);
            }
        } else {
            $this->addTo($to);
        }
    }

    public function addTo($email, $name = null)
    {
        if (null !== $name || is_integer($email)) {
            $this->to[$email] = $name;
        } else {
            $this->to[] = $email;
        }
    }
}
