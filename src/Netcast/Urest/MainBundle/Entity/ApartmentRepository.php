<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ApartmentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApartmentRepository extends EntityRepository
{

    public function getApartmentByType($typeId,$city,$lang)
    {
        $qb = $this->createQueryBuilder('apartment')
            ->select(['apartment'])
            ->where('apartment.city = :city')
            ->andWhere('apartment.lang = :lang')
            ->andWhere('apartment.types = :types')
            ->setParameter('city',$city)
            ->setParameter('types', $typeId)
            ->setParameter('lang', $lang)
            ->orderBy('apartment.title','ASC')
        ;
        return $qb->getQuery()->getResult();
    }

}
