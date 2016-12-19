<?php

namespace AppBundle\Entity\Repository;


use AppBundle\Entity\Depts;
use Doctrine\ORM\EntityRepository;

class DebtsRepository extends EntityRepository
{
    public function findAllUnpaidDebtsForReport($query = false)
    {
        $unpaid = Depts::UNPAID;

        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT d
                 FROM AppBundle:Depts d
                 LEFT JOIN d.fkOrder o
                 LEFT JOIN o.fkReader r
                 WHERE d.status = :unpaid
                 ORDER BY r.personalId ASC'
            )->setParameter('unpaid', $unpaid);
        if(!$query)
        {
            return  $result->getResult();
        }
        else
        {
            return  $result;
        }
    }

    public function findAllUnpaidDebtsSumForReport($query = false)
    {
        $unpaid = Depts::UNPAID;

        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT d, SUM(d.amount) as s
                 FROM AppBundle:Depts d
                 LEFT JOIN d.fkOrder o
                 LEFT JOIN o.fkReader r
                 WHERE (d.status = :unpaid)
                 GROUP BY r.personalId
                 ORDER BY r.personalId ASC'
            )->setParameter('unpaid', $unpaid);
        if(!$query)
        {
            return  $result->getResult();
        }
        else
        {
            return  $result;
        }
    }
}