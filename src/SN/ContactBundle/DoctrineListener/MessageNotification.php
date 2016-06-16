<?php

namespace SN\ContactBundle\DoctrineListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use SN\ContactBundle\Entity\Message;

class MessageNotification
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer=$mailer;
    }

    public function postPersist (LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if(!$entity instanceof Message){
            return;
        }

        $message = new\Swift_Message($entity->getMessage());

        $message->setSubject($entity->getSubject())
            ->addFrom($entity->getEmail())
            ->addTo('dennis@debest.fr');

        $this->mailer->send($message);

    }
}