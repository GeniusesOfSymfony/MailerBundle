#Gos Mailer Bundle#

[![Build Status](https://travis-ci.org/GeniusesOfSymfony/MailerBundle.svg?branch=master)](https://travis-ci.org/GeniusesOfSymfony/MailerBundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GeniusesOfSymfony/MailerBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GeniusesOfSymfony/MailerBundle/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/GeniusesOfSymfony/MailerBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GeniusesOfSymfony/MailerBundle/?branch=master)

**This project is currently in development, please take care.**

Provide an easy way to architecture your mail system on huge projects. Easy to maintains, dedicated class and build your email like you build your form. If you use Symfony/Form, it's really easy to you, MailBuilder have the same API :)

Installation
-------------

You need to have [composer](https://getcomposer.org/) to install dependencies.

```json
{
    "require": {
        "gos/mailer-bundle": "{last stable version}"
    }
}
```

Then run the command on the root of your project`composer update`

Add this line in your `AppKernel.php`

```php
$bundles = array(

	//Other bundles
    new Gos\Bundle\MailerBundle\GosMailerBundle(),
);
```

Usage
-----

First step, we will create an email, each email have his own class like this :

```php
<?php
//Acme/DemoBundle/Mail/RegistrationMail.php

use Gos\Bundle\MailerBundle\Manager\Transport\Mail;
use Gos\Bundle\MailerBundle\Manager\Transport\Builder\MailBuilderInterface;
use Acme\DemoBundle\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationMail extends Mail
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $applicationInfo;

    /**
     * Dependency related to our email.
     * @param $applicationInfo
     */
    public function __construct($applicationInfo)
    {
        $this->applicationInfo = $applicationInfo;
    }

    /**
     * Dependency related to our email.
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param MailBuilderInterface $builder
     * @param array                $options
     */
    public function buildMail(MailBuilderInterface $builder, Array $options)
    {
    	//Build you header fields
        //$builder->($headerType, $value, Array $options)
        $builder->add('to', $this->user->getEmail());

        $builder->add('subject', 'mail.subject', array(
            'parameters' => array('%username%' => $this->user->getUsername(),
            '%app_name%' => $this->applicationInfo['name']),
            'translation_domain' => 'registration'
        ));

        $builder->add('from', 'no-reply@gos.fr');

        /**
         Using the bundle configuration you can make shortcut to centralized emails
         $builder->add('from', 'no_reply');
        */
    }

    /**
     * Send some parameters to the view
     * @param  array $options
     * @return array
     */
    public function finishView(Array $options)
    {
        return array(
            'user' => $this->user
        );
    }

    /**
     * Define options of you
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'template' => 'AcmeDemoBundle:Mail:registration.html.twig'
            //'content_type' => 'text/html' (by default)
        ));
    }

    /**
     * Name of you mail (must be unique)
     * @return string
     */
    public function getName()
    {
        return 'acme_demo_mail_registration';
    }
}
```

From here, RegistrationMail is an abstracted representation of your email. Now register it as service.

```yaml
services:
    acme.demo_bundle.mail.registration:
        class: Acme\DemoBundle\Mail\RegistrationMail
        public: false
        arguments:
            - %project%
        tags:
            - { name: mail }
```

Send the email :

```php
<?php
//Acme/DemoBundle/EventListener/UserSubscriber.php

use Gos\Bundle\MailerBundle\Manager\Transport\MailFactory;
use Gos\Bundle\MailerBundle\Manager\Transport\MailTransportManager;
use Gos\Bundle\ResourceBundle\ClassInterface\ActiveStateInterface;
use Gos\Bundle\UserBundle\Events\UserLifeCycleEvent;
use Gos\Bundle\UserBundle\Events\UserLifeCycleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Gos\Bundle\MailerBundle\Manager\Transport\MailTransportManager
     */
    protected $mailTransportManager;

     /**
     * @var \Gos\Bundle\MailerBundle\Manager\Transport\MailFactory
     */
    protected $mailFactory;


    /**
     * Inject our dependencies
     * @param MailTransportManager $mailTransportManager
     * @param MailFactory          $mailFactory
     */
    public function __construct(MailTransportManager $mailTransportManager, MailFactory $mailFactory)
    {
        $this->mailTransportManager = $mailTransportManager;
        $this->mailFactory = $mailFactory;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            UserLifeCycleEvents::NEW_USER => array('onNewUser', 0),
        ];
    }

    /**
     * @param UserLifeCycleEvent $event
     */
    public function onNewUser(UserLifeCycleEvent $event)
    {
		$user = $event->getUser();

        //Create our email
        $registrationMail = $this->mailFactory->createNamed('acme_demo_mail_registration');
        $registrationMail->setUser($user);

        /**
        * The factory is not needed in our case because we send only one mail. Factory avoid
        * to inject many dependencies, because you can directly inject acme.demo_bundle.mail.registration
        *
        * public function __construct(RegistrationMail $registrationMail, MailTransportManager $manager){
        *   $registrationMail->setUser($user);
        *  	$manager->send($registrationMail);
        * }
        *
        **/

        //Send it
        $this->mailTransportManager->send($registrationMail);
    }
}
```

### Events ###

When mail has send, we dispatch an event named : `gos.mailer_bundle.mail_send` (`MailerEvents::MAIL_SEND`) events.

Event class :

```php
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

```




Running the tests:
------------------

PHPUnit 3.5 or newer together with Mock_Object package is required. To setup and run tests follow these steps:

* go to the root directory of fixture
* run: composer install --dev
* run: phpunit

License
---------

The project is under MIT lisence, for more information see the LICENSE file inside the project
