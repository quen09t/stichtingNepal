<?php

namespace SN\ContactBundle\Email;

use Doctrine\ORM\EntityManager;
use SN\ContactBundle\Entity\Message;


class GetAddress
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em=$em;
    }

    public function getAddress ($role){

        return $this->em->getRepository('SNUserBundle:User')
            ->findEmails($role);

    }

}