<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;


class OptionsRepository extends EntityRepository
{

    public function getOptionsWithImages($id)
    {
        $qb = $this->createQueryBuilder('option')
            ->select(['option','images'])
            ->leftJoin('option.images', 'images', 'WITH', 'images.main = :main')
            ->andWhere('option.service = :id')
            ->setParameter('id',$id)
            ->setParameter('main',true)
            ->orderBy('option.title','ASC')
        ;
        return $qb->getQuery()->getResult();
    }
}