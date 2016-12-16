<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository
{
    public function findAllOrders($query = false)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT o, r, e, b
                 FROM AppBundle:Orders o 
                 LEFT JOIN o.fkReader r 
                 LEFT JOIN o.fkEmploye e 
                 LEFT JOIN o.fkBook b'
            );
        if(!$query)
        {
            return  $result->getResult();
        }
        else
        {
            return  $result;
        }
    }

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

    public function findOrdersByBookReader($search, $query = false)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT o, r, e, b 
                 FROM AppBundle:Orders o 
                 LEFT JOIN o.fkReader r 
                 LEFT JOIN o.fkEmploye e 
                 LEFT JOIN o.fkBook b
                 WHERE b.title LIKE :search OR r.name LIKE :search OR r.lastName LIKE :search'
            )->setParameter('search', '%'.$search.'%');
        if(!$query)
        {
            return $result->getResult();
        }
        else
        {
            return $result;
        }
    }
}