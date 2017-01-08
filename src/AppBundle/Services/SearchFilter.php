<?php

namespace AppBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class SearchFilter
{
    public function __construct(EntityManager $em, Session $session)
    {
        $this->em = $em;
        $this->session = $session;
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

    public function isAuthorInSession($id){
        $filters = $this->session->get("filters");
        if(!empty($filters)){
            if(isset($filters['authors'])){
                return in_array($id, $filters['authors']);
            }
        }
        return false;
    }
    public function isLanguageInSession($id){
        $filters = $this->session->get("filters");
        if(!empty($filters)){
            if(isset($filters['languages'])){
                return in_array($id, $filters['languages']);
            }
        }
        return false;
    }
    public function isGenreInSession($id){
        $filters = $this->session->get("filters");
        if(!empty($filters)){
            if(isset($filters['genres'])){
                return in_array($id, $filters['genres']);
            }
        }
        return false;
    }
}