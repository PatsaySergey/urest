<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MainGalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MainGalleryRepository extends EntityRepository
{
    /**
     * @param string(2) $lang
     * @return array
     */
    public function findGallery($lang)
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g')
            ->where('g.lang = :lang')
            ->where('g.active = :active')
            ->setParameter('lang', $lang)
            ->setParameter('active', true)
        ;
        return $qb->getQuery()->getResult();
    }
}