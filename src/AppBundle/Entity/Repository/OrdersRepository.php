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

    public function findOrdersByReader($id, $query = false)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT o, r, e, b
                 FROM AppBundle:Orders o 
                 LEFT JOIN o.fkReader r 
                 LEFT JOIN o.fkEmploye e 
                 LEFT JOIN o.fkBook b
                 WHERE r.personalId = :id ORDER BY o.takeDate'
            )->setParameter("id", $id);
        if(!$query)
        {
            return  $result->getResult();
        }
        else
        {
            return  $result;
        }
    }

    public function findOrdersGroupsCountForReport($id, $beginDate, $endDate)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT o, b, g, COUNT(g) AS cnt
                 FROM AppBundle:Orders o 
                 LEFT JOIN o.fkReader r 
                 LEFT JOIN o.fkEmploye e 
                 LEFT JOIN o.fkBook b
                 LEFT JOIN b.fkGenre g
                 WHERE r.personalId = :id 
                 AND o.takeDate >= :beginDate AND o.takeDate <= :endDate GROUP BY g.id ORDER BY o.takeDate'
            )->setParameter("id", $id)
            ->setParameter("beginDate", $beginDate)
            ->setParameter("endDate", $endDate)
            ->getResult();
    }

    public function findOrdersCountForReport($id, $beginDate, $endDate)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT COUNT(o) AS cnt
                 FROM AppBundle:Orders o
                 LEFT JOIN o.fkReader r 
                 WHERE r.personalId = :id 
                 AND o.takeDate >= :beginDate AND o.takeDate <= :endDate ORDER BY o.takeDate'
            )->setParameter("id", $id)
            ->setParameter("beginDate", $beginDate)
            ->setParameter("endDate", $endDate)
            ->getResult();
    }

    public function findOrdersLanguagesCountForReport($id, $beginDate, $endDate)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT o, b, l, COUNT(l) AS cnt
                 FROM AppBundle:Orders o 
                 LEFT JOIN o.fkReader r 
                 LEFT JOIN o.fkEmploye e 
                 LEFT JOIN o.fkBook b
                 LEFT JOIN b.fkLanguage l
                 WHERE r.personalId = :id 
                 AND o.takeDate >= :beginDate AND o.takeDate <= :endDate GROUP BY l.id ORDER BY o.takeDate'
            )->setParameter("id", $id)
            ->setParameter("beginDate", $beginDate)
            ->setParameter("endDate", $endDate)
            ->getResult();
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

    public function findOrdersByDateAndReaderForReport($beginDate, $endDate, $reader, $query = false)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT o, r, b
                 FROM AppBundle:Orders o 
                 LEFT JOIN o.fkReader r 
                 LEFT JOIN o.fkBook b
                 WHERE o.takeDate >= :beginDate AND o.takeDate <= :endDate AND r.personalId = :reader
                 ORDER BY o.takeDate DESC'
            )->setParameters(array('beginDate' => $beginDate, 'endDate' => $endDate, 'reader' => $reader));
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