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
}