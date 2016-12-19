<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;



class PenaltyRepository extends  EntityRepository
{

    public function isActivePenalty($userId){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT p, r FROM AppBundle:Penalty p LEFT JOIN p.fkReader r
                        WHERE r.personalId = :userId 
                        AND p.penaltyBeginDate < CURRENT_TIMESTAMP() 
                        AND p.penaltyEndDate > CURRENT_TIMESTAMP()'
            )->setParameter("userId", $userId)
            ->getResult();

        if(!empty($result[0]))
            return true;
        return false;
    }
}