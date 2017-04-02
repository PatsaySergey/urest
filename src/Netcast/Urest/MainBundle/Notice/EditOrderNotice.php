<?php

namespace Netcast\Urest\MainBundle\Notice;

class EditOrderNotice extends BaseNotice
{
    /**
     * get new review
     * @return array
     */
    public function getEditOrders()
    {
        $ordersRepository = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder');
        $newOrders = $ordersRepository->findBy(['lang' => $this->getCurrentLocale(), 'moderator' => $this->getUser()->getId(), 'status' => 0],['created' => 'DESC']);
        return $newOrders;
    }
}