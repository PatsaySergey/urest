<?php

    namespace Netcast\Urest\MainBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Netcast\Urest\MainBundle\Entity\PayOrders;

    class AjaxAdminController extends Controller
    {

        public function addPayOrderAction()
        {
            $params = $this->get('request')->request->all();
            $ctId = $params['id'];
            $preAmount = $params['amount'];
            $em = $this->getDoctrine()->getManager();
            $customTour = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($ctId);
            if($customTour) {
                $amount = $customTour->makePrice();
                $preAmount = ($preAmount > 0) ? $preAmount : ($amount/100)*10;

                $payOrders = $customTour->getPayOrder();
                $payOrder = (count($payOrders)) ? $payOrders[0] : new PayOrders();

                $payOrder->setPayDate(new \DateTime('+7 day'));
                $payOrder->setCreated(new \DateTime());
                $payOrder->setUser($customTour->getAuthor());
                $payOrder->setOrder($customTour);
                $payOrder->setAmount($amount);
                $payOrder->setPreAmount($preAmount);
                $em->persist($payOrder);
                $em->flush();
            }
            return new Response(json_encode(['status' => 'success']));
        }

        public function addTourCityAction()
        {
            $em = $this->getDoctrine()->getManager();
            $lang = $this->getRequest()->getLocale();
            $cityIds = $this->getRequest()->request->get('cityIds');
            if(!is_array($cityIds))
                $cityIds = [];
            $city = $em->getRepository('Netcast\Urest\MainBundle\Entity\City')->findBy(['lang' => $lang]);
            foreach($city as $row)
            {
                $row->setInBuilder((in_array($row->getId(),$cityIds)));
                $em->persist($row);
                $em->flush();
            }

            return new Response(json_encode($cityIds));
        }

        public function getOptionsAction()
        {
            $em = $this->getDoctrine()->getManager();
            $response = [];
            $serviceId = $this->getRequest()->request->get('id');
            $service = $em->getRepository('Netcast\Urest\MainBundle\Entity\Service')->find($serviceId);
            if(!empty($service)) {
                $response['type'] = $service->getType();
                $response['options'] = [];
                $options = $service->getOptions();
                if(!empty($options)) {
                    foreach($options as $option) {
                        $oneOption['id']    = $option->getId();
                        $oneOption['title'] = $option->getTitle();
                        $response['options'][] = $oneOption;
                    }
                }
            }
            return new Response(json_encode($response));
        }

        public function getOptionInfoAction()
        {
            $em = $this->getDoctrine()->getManager();
            $response = [];
            $optionId = $this->getRequest()->request->get('id');
            $option = $em->getRepository('Netcast\Urest\MainBundle\Entity\Options')->find($optionId);
            if(!empty($option)) {
                $options = $option->getService()->getOptions();
                if(!empty($options)) {
                    foreach($options as $option) {
                        $oneOption['id']    = $option->getId();
                        $oneOption['title'] = $option->getTitle();
                        $response[] = $oneOption;
                    }
                }
            }
            return new Response(json_encode($response));
        }

        public function getRoomsAction()
        {
            $em = $this->getDoctrine()->getManager();
            $response = [];
            $hotelId = $this->getRequest()->request->get('id');
            $hotel = $em->getRepository('Netcast\Urest\MainBundle\Entity\Hotel')->find($hotelId);
            if(!empty($hotel)) {
                $rooms = $hotel->getRooms();
                if(!empty($rooms)) {
                    foreach($rooms as $room) {
                        $oneOption['id']    = $room->getId();
                        $oneOption['title'] = $room->getTitle();
                        $response[] = $oneOption;
                    }
                }
            }
            return new Response(json_encode($response));
        }



    }
