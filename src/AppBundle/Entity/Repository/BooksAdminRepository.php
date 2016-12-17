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



class BooksAdminRepository extends  EntityRepository
{
    public function findBooksAdminByFosUser($id){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT b, fos FROM AppBundle:BooksAdmins b LEFT JOIN b.fkFosuser fos WHERE fos.id = :id'
            )->setParameter("id", $id)
            ->getResult()[0];
    }

}