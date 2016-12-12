<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;



class WishlistRepository extends  EntityRepository
{


    public function findWishlist($userId, $bookId){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT w, r, b, fos FROM AppBundle:Wishlists w LEFT JOIN w.fkReader r LEFT JOIN r.fkFosuser fos LEFT JOIN w.fkBook b WHERE fos.id = :userId AND b.id = :bookId'
            )->setParameter("userId", $userId)
            ->setParameter("bookId", $bookId)
            ->getResult();
    }
}