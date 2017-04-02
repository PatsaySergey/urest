<?php

namespace Netcast\Urest\MainBundle\Notice;

class NewOrderNotice extends BaseNotice
{
    /**
     * get new review
     * @return array
     */
    public function getNewOrders()
    {
        $ordersRepository = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder');
        $newOrders = $ordersRepository->findBy(['lang' => $this->getCurrentLocale(), 'moderator' => null],['created' => 'DESC']);
        return $newOrders;
    }
}