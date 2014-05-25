<?php
namespace Gos\Bundle\MailerBundle\Events;

use Symfony\Component\EventDispatcher\Event;

class OnEmailSendEvent extends Event
{
    protected $message;

    public function __construct(\Swift_Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Swift_Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
