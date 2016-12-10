<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 13/08/2016
 * Time: 20:13
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;



class BooksRepository extends  EntityRepository
{
    // @param $query - false: returns result as objects,
    //                  true: returns result as SQL builder query
    public function findAllBooks($query = false){
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT b, p, l, g, a FROM AppBundle:Books b LEFT JOIN b.fkPublisher p LEFT JOIN b.fkLanguage l LEFT JOIN b.fkGenre g LEFT JOIN b.fkAuthor a'
            );
        if(!$query){
            return  $result->getResult();
        }else{
            return  $result;
        }

    }
}