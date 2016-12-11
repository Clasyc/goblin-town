<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;



class ReadersRepository extends  EntityRepository
{
    // @param $query - false: returns result as objects,
    //                  true: returns result as SQL builder query
    public function findAllReaders($query = false){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT r, fos FROM AppBundle:Readers r LEFT JOIN r.fkFosuser fos'
            );
        if(!$query){
            return  $result->getResult();
        }else{
            return  $result;
        }

    }

    public function findReader($id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r, fos FROM AppBundle:Readers r LEFT JOIN r.fkFosuser fos WHERE r.personalId = :id'
            )->setParameter("id", $id)
            ->getResult()[0];
    }

    public function findReaderByFosUser($id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r, fos FROM AppBundle:Readers r LEFT JOIN r.fkFosuser fos WHERE fos.id = :id'
            )->setParameter("id", $id)
            ->getResult()[0];
    }
}