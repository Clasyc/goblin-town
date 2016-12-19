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

    // @param $query - false: returns result as objects,
    //                  true: returns result as SQL builder query
    public function findBook($query = false, $bookId){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT b, p, l, g, a FROM AppBundle:Books b 
                LEFT JOIN b.fkPublisher p 
                LEFT JOIN b.fkLanguage l 
                LEFT JOIN b.fkGenre g 
                LEFT JOIN b.fkAuthor a
                WHERE b.id = :bookId')
                ->setParameter("bookId", $bookId);
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



    // @param $query - false: returns result as objects,
    //                  true: returns result as SQL builder query
    public function findOrderedBooks($query = false, $startDate, $endDate){
        $result = $this->getEntityManager()
            ->createQuery(
                "SELECT b, a, g, l, p, o 
                FROM AppBundle:Books b 
                LEFT JOIN b.fkAuthor a LEFT JOIN b.fkGenre g 
                LEFT JOIN b.fkLanguage l LEFT JOIN b.fkPublisher p 
                LEFT JOIN b.orders o 
                WHERE o.actualReturnDate > :startDate
                AND o.actualReturnDate <:endDate"
            )->setParameter("startDate", $startDate)
            ->setParameter("endDate", $endDate);
        if(!$query){
            return  $result->getResult();
        }else{
            return  $result;
        }
    }


    public function getOutdatedReservationsBooksIds()
    {
        $ordering = Reservations::ORDERING;

        return $this->getEntityManager()
            ->createQuery(
                'SELECT b.id
                     FROM AppBundle:Books b
                     WHERE b.ordered = true 
                     AND b.id IN (SELECT IDENTITY(r.fkBook) FROM AppBundle:Reservations r WHERE r.status = :ordering AND DATE_DIFF(CURRENT_DATE(), r.queueMoved) > 1)'
            )->setParameter('ordering', $ordering)
            ->getResult();
    }

    public function checkBookReservations($books)
    {
        $ordering = Reservations::ORDERING;
        $cancelled = Reservations::CANCELLED;
        $reserved = Reservations::RESERVED;
        $waiting = Orders::WAITING;
        $borrowed = Orders::BORROWED;

        $em = $this->getEntityManager();

        $em->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.status = :cancelled, r.queue = -1
                 WHERE r.status = :ordering AND DATE_DIFF(CURRENT_DATE(), r.queueMoved) > 1'
            )->setParameters(array('ordering' => $ordering, 'cancelled' => $cancelled))
            ->execute();

        $em->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.queue = r.queue - 1, r.queueMoved = CURRENT_DATE()
                 WHERE r.fkBook IN (:books) AND (r.status = :ordering OR r.status = :reserved)'
            )->setParameters(array('books' => $books, 'ordering' => $ordering, 'reserved' => $reserved))
            ->execute();

        $em->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.status = :ordering
                 WHERE r.queue = 0 AND r.fkBook IN (:books)'
            )->setParameters(array('books' => $books, 'ordering' => $ordering))
            ->execute();

        $em->createQuery(
            'UPDATE AppBundle:Books b
             SET b.ordered = FALSE 
             WHERE b.id IN (:books)
             AND NOT EXISTS (SELECT r FROM AppBundle:Reservations r WHERE r.fkBook = b.id AND (r.status = :reserved OR r.status = :ordering))
             AND NOT EXISTS (SELECT o FROM AppBundle:Orders o WHERE o.fkBook = b.id AND (o.status = :waiting OR o.status = :borrowed))'
        )->setParameters(array('books' => $books, 'reserved' => $reserved, 'ordering' => $ordering, 'waiting' => $waiting, 'borrowed' => $borrowed))
            ->execute();
    }

}