<?php

namespace AppBundle\Services;
use Doctrine\ORM\EntityManager;

class SearchFilter
{
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAuthors(){
        return $this->em->getRepository("AppBundle:Authors")->findAll();
    }
    public function getGenres(){
        return $this->em->getRepository("AppBundle:Genres")->findAll();
    }
    public function getLanguages(){
        return $this->em->getRepository("AppBundle:Languages")->findAll();
    }
    public function getPublishers(){
        return $this->em->getRepository("AppBundle:Publishers")->findAll();
    }
}