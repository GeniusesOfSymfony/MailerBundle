<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport;

use Gos\Bundle\MailerBundle\Events\MailerEvents;
use Gos\Bundle\MailerBundle\Events\OnEmailSendEvent;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MailTransportManager
{
    protected $mailer;
    protected $engine;
    protected $emailProvider;
    protected $translator;
    protected $eventDispatcher;

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function setMailer(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setEngine(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function setEmailServices($emailProvider)
    {
        $this->emailProvider = $emailProvider;
    }

    public function send(MailInterface $mail)
    {
        $mailBuilder = $mail->getBuilder();
        $mailBuilder->setTranslator($this->translator);
        $message = $mailBuilder->render($this->engine, $this->emailProvider);

        $onMessageMailEvent = new OnEmailSendEvent($message);
        $this->eventDispatcher->dispatch(MailerEvents::MAIL_SEND, $onMessageMailEvent);

        $this->mailer->send($onMessageMailEvent->getMessage());
    }
}
