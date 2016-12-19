<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class EmployeesRepository extends EntityRepository
{
    public function findEmployeeByFosUser($id){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT e, fos FROM AppBundle:Employees e LEFT JOIN e.fkFosuser fos WHERE fos.id = :id'
            )->setParameter("id", $id)
            ->getResult();

        if(!empty($result[0]))
            return $result[0];
        return null;
    }
}