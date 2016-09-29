<?php

namespace SN\ContactBundle\Email;

use SN\ContactBundle\Entity\Message;


class MessageNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer=$mailer;
    }

    public function newMessageNotification (Message $message ){

        $swiftMessage = new\Swift_Message($message->getMessage());

        $swiftMessage->setSubject($message->getSubject())
            ->addFrom($message->getEmail())
            ->addTo('dennis@debest.fr')
            ->setBody($message->getMessage());

        $this->mailer->send($swiftMessage);

    }
    
}