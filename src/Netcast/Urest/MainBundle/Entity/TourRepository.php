<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;


class TourRepository extends EntityRepository
{

    public function getLastTours($limit)
    {
        $qb = $this->createQueryBuilder('tour')
            ->select(['tour','images'])
            ->leftJoin('tour.tour_images', 'images', 'WITH', 'images.main = :main')
            ->where('tour.active = :active')
            ->andWhere('tour.hot_offer = :hot_offer')
            ->andWhere('tour.datePublish <= :datePublish')
            ->setParameter('main',true)
            ->setParameter('hot_offer',true)
            ->setParameter('active', true)
            ->setParameter('datePublish', new \DateTime())
            ->setFirstResult(0)
            ->setMaxResults($limit)
            ->orderBy('tour.created','DESC')
        ;
        return $qb->getQuery()->getResult();
    }

    public function getAllTours($tourCity,  $offset, $limit)
    {
        $qb = $this->createQueryBuilder('tour')
            ->select(['tour','images'])
            ->leftJoin('tour.tour_images', 'images', 'WITH', 'images.main = :main')
            ->where('tour.active = :active')
            ->andWhere('tour.datePublish <= :datePublish')
            ->setParameter('main',true)
            ->setParameter('active', true)
            ->setParameter('datePublish', new \DateTime())
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('tour.created','DESC')
        ;

        if(!empty($tourCity)) {
            if(is_array($tourCity)) {
                $qb->andWhere('tour.city IN (:city)')
                    ->setParameter('city', $tourCity);
            } else {
                $qb->andWhere('tour.city = :city')
                    ->setParameter('city', $tourCity);
            }
        }

        return $qb->getQuery()->getResult();
    }

    public function getTourCities()
    {
        $qb = $this->createQueryBuilder('tour')
            ->select(['tour','city'])
            ->leftJoin('tour.city', 'city')
            ->where('tour.active = :active')
            ->andWhere('tour.datePublish <= :datePublish')
            ->setParameter('active', true)
            ->setParameter('datePublish', new \DateTime())
            ->orderBy('tour.created','DESC')
        ;
        return $qb->getQuery()->getResult();
    }

    public function searchTours($search,$lang)
    {
        $qb = $this->createQueryBuilder('tour')
            ->select(['tour','images'])
            ->leftJoin('tour.tour_images', 'images', 'WITH', 'images.main = :main')
            ->join('tour.tour_content', 'tour_content', 'WITH', 'tour_content.lang = :lang')
            ->where('tour.active = :active')
            ->andWhere('tour_content.title like :search OR tour_content.description like :search')
            ->setParameter('search',"%{$search}%")
            ->andWhere('tour.datePublish <= :datePublish')
            ->setParameter('main',true)
            ->setParameter('lang',$lang)
            ->setParameter('active', true)
            ->setParameter('datePublish', new \DateTime())
            ->orderBy('tour.created','DESC')
        ;
        return $qb->getQuery()->getResult();
    }

}