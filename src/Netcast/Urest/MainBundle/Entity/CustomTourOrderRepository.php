<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * CustomTourOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomTourOrderRepository extends \Doctrine\ORM\EntityRepository
{
    private $statusSettings = [
        'moderation'   => 0,
        'for_approval' => 1,
        'pending_payments' => 2,
        'overdue' => 3,
        'paid' => 4,
    ];

    public function getListByStatus($user,$status)
    {
        $statusInt = $this->statusSettings[$status];
        $qb = $this->createQueryBuilder('custom_tour_order')
            ->select(['custom_tour_order'])
            ->where('custom_tour_order.author = :author')
            ->andWhere('custom_tour_order.isCancel = 0');


        if($statusInt == 3 || $statusInt == 2) {
            switch($statusInt) {
                case 2:
                    $qb->andWhere('custom_tour_order.payTo >= :now')
                        ->setParameter('now',(new \DateTime())->format('Y-m-d'));
                    break;
                case 3:
                    $qb->andWhere('custom_tour_order.payTo < :now')
                        ->setParameter('now',(new \DateTime())->format('Y-m-d'));
            }
            $statusInt = 2;
        }

        $qb->andWhere('custom_tour_order.status = :status')
            ->setParameter('author',$user->getId())
            ->setParameter('status',$statusInt)
            ->orderBy('custom_tour_order.created','ASC')
        ;
        return $qb->getQuery()->getResult();
    }



}
