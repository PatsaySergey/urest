<?php

namespace Netcast\Urest\MainBundle\Twig;

class TourServicePriceExtension extends \Twig_Extension
{
    public function getFunctions() {
        return [
            'servicePrice' => new \Twig_Function_Method($this, 'getPrice')
        ];
    }

    public function getPrice($tourService)
    {
        $price = 0;
        $serviceType = $tourService->getService()->getType();
        switch($serviceType) {
            case 'line':
                $price = $tourService->getService()->getPrice();
                break;
            case 'day':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $price = $tourService->getService()->getPrice()*$daysCount;
                break;
            case 'day_option':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $option = $tourService->getOption();
                if(!empty($option)) {
                    $price = $option->getPrice()*$daysCount;
                }
                break;
            case 'option':
                $option = $tourService->getOption();
                if(!empty($option)){
                    $price = $option->getPrice();
                }
                break;
        }
        return $price;
    }

    public function getName()
    {
        return 'netcast.urest.twig.tour_order_form';
    }
}