<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository
{

    public function findOrdersCount($readerId){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT o, r FROM AppBundle:Orders o LEFT JOIN o.fkReader r WHERE r.personalId = :id'
            )->setParameter("id", $readerId)
            ->getResult();

        if(empty($result))
            return 0;
        return count($result[0]);
    }

}