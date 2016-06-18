<?php

namespace SN\ContactBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use SN\BlogBundle\Entity\Post;
use SN\ContactBundle\Entity\Message;
use SN\ContactBundle\Email\MessageNotification;

class MessageCreationListener
{
    /**
     * MessageCreationListener constructor.
     * @var MessageNotification
     */
    public function __construct(MessageNotification $messageNotification)
    {
        $this->messageNotification=$messageNotification;
    }

    public function postPersist (LifecycleEventArgs $args ){

        $entity = $args->getObject();

        if($entity instanceof Message){
            $this->messageNotification->newMessageNotification($entity);
        }

        else {
            return;
        }

    }
}