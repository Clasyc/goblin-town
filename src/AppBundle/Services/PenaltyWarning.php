<?php

namespace AppBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 16/12/2016
 * Time: 23:35
 */
class PenaltyWarning
{
    public function __construct(TokenStorageInterface $tokenStorage, EntityManager $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
        if(self::getUser() !== null)
            $this->reader = $this->em->getRepository("AppBundle:Readers")->findReaderByFosUser(self::getUser()->getId());
    }

    public function is_active(){

        return $this->reader->hasActivePenalty();
    }

    public function info(){
        return $this->reader->getActivePenalty();
    }

    private function getUser(){
        if (null === $token = $this->tokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }
}