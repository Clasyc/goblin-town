<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Orders;
use AppBundle\Entity\Reservations;
use Doctrine\ORM\EntityRepository;



class ReadersRepository extends  EntityRepository
{
    // @param $query - false: returns result as objects,
    //                  true: returns result as SQL builder query
    public function findAllReaders($query = false){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT r, fos, p FROM AppBundle:Readers r LEFT JOIN r.fkFosuser fos LEFT JOIN r.penalty p'
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
                'SELECT r, fos, p FROM AppBundle:Readers r LEFT JOIN r.fkFosuser fos LEFT JOIN r.penalty p WHERE r.personalId = :id'
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

    public function isBookAlreadyOrderedByReader($userId, $bookId)
    {
        $borrowed = Orders::BORROWED;
        $waiting = Orders::WAITING;
        $value = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(o.id)
                 FROM AppBundle:Orders o
                 WHERE o.fkReader = :userId AND (o.status = :borrowed OR o.status = :waiting) AND o.fkBook = :bookId'
            )->setParameters(array('userId' => $userId, 'bookId' => $bookId, 'borrowed' => $borrowed, 'waiting' => $waiting))
            ->getResult()[0];

        if ($value[1] > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isBookAlreadyReservedByReader($userId, $bookId)
    {
        $ordering = Reservations::ORDERING;
        $reserved = Reservations::RESERVED;

        $value = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(r.id)
                 FROM AppBundle:Reservations r
                 WHERE r.fkReader = :userId AND (r.status = :ordering OR r.status = :reserved) AND r.fkBook = :bookId'
            )->setParameters(array('userId' => $userId, 'bookId' => $bookId, 'reserved' => $reserved, 'ordering' => $ordering))
            ->getResult()[0];

        if ($value[1] > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}