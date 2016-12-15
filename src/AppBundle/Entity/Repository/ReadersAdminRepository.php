<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;



class ReadersAdminRepository extends  EntityRepository
{
    public function findReadersAdminByFosUser($id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r, fos FROM AppBundle:ReadersAdmin r LEFT JOIN r.fkFosuser fos WHERE fos.id = :id'
            )->setParameter("id", $id)
            ->getResult()[0];
    }

}