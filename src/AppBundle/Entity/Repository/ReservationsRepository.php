<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Reservations;
use Doctrine\ORM\EntityRepository;

class ReservationsRepository extends EntityRepository
{
    public function countQueueNumber($bookId, $query = false)
    {
        $reserved = Reservations::RESERVED;
        $ordering = Reservations::ORDERING;

        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(r.id)
                 FROM AppBundle:Reservations r
                 WHERE r.fkBook = :bookId AND (r.status = :reserved OR r.status = :ordering)'
            )->setParameters(array('reserved' => $reserved, 'ordering' => $ordering, 'bookId' => $bookId));
        if (!$query)
        {
            return  $result->getResult();
        }
        else
        {
            return  $result;
        }
    }

    public function refreshReservations($bookId, $queueMoved)
    {
        $ordering = Reservations::ORDERING;
        $reserved = Reservations::RESERVED;

        $this->getEntityManager()
            ->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.queue = r.queue - 1, r.queueMoved = :queueMoved
                 WHERE r.fkBook = :bookId AND r.status = :reserved'
            )->setParameters(array('bookId' => $bookId, 'reserved' => $reserved, 'queueMoved' => $queueMoved))
             ->execute();

        $this->getEntityManager()
            ->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.status = :ordering
                 WHERE r.queue = 0 AND r.fkBook = :bookId AND r.status = :reserved'
            )->setParameters(array('bookId' => $bookId, 'reserved' => $reserved, 'ordering' => $ordering))
            ->execute();
    }

    public function refreshReservationsAfterCancel($bookId, $queueMoved, $queue)
    {
        $ordering = Reservations::ORDERING;
        $reserved = Reservations::RESERVED;

        $this->getEntityManager()
            ->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.queue = r.queue - 1, r.queueMoved = :queueMoved
                 WHERE r.fkBook = :bookId AND r.status = :reserved AND r.queue > :queue'
            )->setParameters(array('bookId' => $bookId, 'reserved' => $reserved, 'queueMoved' => $queueMoved, 'queue' => $queue))
            ->execute();

        $this->getEntityManager()
            ->createQuery(
                'UPDATE AppBundle:Reservations r
                 SET r.status = :ordering
                 WHERE r.queue = 0 AND r.fkBook = :bookId AND r.status = :reserved'
            )->setParameters(array('bookId' => $bookId, 'reserved' => $reserved, 'ordering' => $ordering))
            ->execute();
    }

    public function findReadersReservations($readerId, $query = false)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT r
                 FROM AppBundle:Reservations r
                 WHERE r.fkReader = :readerId
                 ORDER BY r.date'
            )->setParameter('readerId', $readerId);
        if (!$query)
        {
            return  $result->getResult();
        }
        else
        {
            return  $result;
        }
    }
}