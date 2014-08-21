<?php
namespace Gos\Bundle\MailerBundle\Manager\Transport\Builder;

use Symfony\Component\Translation\Translator;

interface BuilderMessageInterface
{
    /**
     * @param  string $from
     * @return void
     */
    public function setFrom($from);

    /**
     * @return void
     */
    public function setTranslator(Translator $translator);

    /**
     * @return void
     */
    public function addFrom($email, $name = null);

    /**
     * @return \Swift_Message
     */
    public function render($emailService);

    public function getForm();

    /**
     * @param  string $subject
     * @return void
     */
    public function setSubject($subject, array $options = []);

    /**
     * @return string
     */
    public function renderSubject();

    /**
     * @param  string $to
     * @return void
     */
    public function setTo($to);

    /**
     * @return void
     */
    public function addTo($email, $name = null);
}
