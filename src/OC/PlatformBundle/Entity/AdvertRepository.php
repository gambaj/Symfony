<?php
// src/OC/PlatformBundle/Entity/AdvertRepository.php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdvertRepository extends EntityRepository
{
  public function getAdverts($page, $nbPerPage)
  {
    $query = $this->createQueryBuilder('a')
      ->orderBy('a.date', 'DESC')
      ->leftJoin('a.image','i')
      ->addSelect('i')
      ->leftJoin('a.categories','c')
      ->addSelect('c')
      ->getQuery()
    ;

    $query
    	->setFirstResult(($page-1) * ($nbPerPage))
    	->setMaxResults($nbPerPage)
    ;

    return new Paginator($query, true);
  }
}