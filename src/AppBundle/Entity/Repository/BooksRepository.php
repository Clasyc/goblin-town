<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Reservations;
use Doctrine\ORM\EntityRepository;



class BooksRepository extends  EntityRepository
{
    // @param $query - false: returns result as objects,
    //                  true: returns result as SQL builder query
    public function findAllBooks($query = false){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT b, p, l, g, a FROM AppBundle:Books b LEFT JOIN b.fkPublisher p LEFT JOIN b.fkLanguage l LEFT JOIN b.fkGenre g LEFT JOIN b.fkAuthor a'
            );
        if(!$query){
            return  $result->getResult();
        }else{
            return  $result;
        }

    }

    public function findBooksInWishlist($userId, $query = false){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT b, w, u FROM AppBundle:Books b LEFT JOIN b.wishlists w LEFT JOIN w.fkReader u WHERE u.personalId = :userId'
            )->setParameter("userId", $userId);
        if(!$query){
            return  $result->getResult();
        }else{
            return  $result;
        }
    }

    public function checkBookReservations()
    {
        $ordering = Reservations::ORDERING;
        $cancelled = Reservations::CANCELLED;

        $this->getEntityManager()
            ->createQuery(
                'UPDATE AppBundle:Books b
                 SET b.ordered = false
                 WHERE b.ordered = true
                 AND b.id IN (SELECT IDENTITY(r.fkBook) FROM AppBundle:Reservations r WHERE r.status = :ordering AND DATE_DIFF(CURRENT_DATE(), r.queueMoved) > 1)'
            )->setParameter('ordering', $ordering)
            ->execute();

        $this->getEntityManager()
            ->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.status = :cancelled
                 WHERE r.status = :ordering AND DATE_DIFF(CURRENT_DATE(), r.queueMoved) > 1'
            )->setParameters(array('ordering' => $ordering, 'cancelled' => $cancelled))
            ->execute();
    }
}