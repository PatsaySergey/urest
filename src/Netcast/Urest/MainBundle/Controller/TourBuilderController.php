<?php

    namespace Netcast\Urest\MainBundle\Controller;

    use Netcast\Urest\MainBundle\Controller\MainController as Controller;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Netcast\Urest\MainBundle\Entity\CustomTourOrder;
    use Netcast\Urest\MainBundle\Entity\CustomTourServices;


    class TourBuilderController extends Controller
    {
        public function indexAction()
        {
            $lang = $this->getRequest()->getLocale();
            $em = $this->getDoctrine()->getManager();
            $cities = $em->getRepository('Netcast\Urest\MainBundle\Entity\City')->findBy(['lang' => $lang, 'in_builder' => true]);
            $fromCountry = $em->getRepository('Netcast\Urest\MainBundle\Entity\Country')->findBy(['lang' => $lang]);
            $welcomeText = $em->getRepository('Netcast\Urest\MainBundle\Entity\WellcomeMsg')->findBy(['lang' => $lang]);
            if(!empty($welcomeText)) {
                $welcomeText = $welcomeText[0];
            } else {
                $welcomeText['messageGuest'] = 'не задано';
                $welcomeText['messageUser'] = 'не задано';
            }
            $toCountry = [];
            foreach($cities as $city) {
                $country = $city->getRegion()->getCountry();
                $toCountry[$country->getId()] = $country->getTitle();
            }
            $apartmentTypes = $em->getRepository('Netcast\Urest\MainBundle\Entity\ApartmentType')->findBy(['lang' => $lang]);
            $data['apartmentTypes'] = $apartmentTypes;
            $data['welcomeText'] = $welcomeText;
            $data['cities'] = $cities;
            $data['toCountry'] = $toCountry;
            $data['fromCountry'] = $fromCountry;

            return $this->render('NetcastUrestMainBundle:Tour:tour_builder.html.twig',$data);
        }

        public function addTourAction()
        {
            $lang = $this->getRequest()->getLocale();
            $data = $this->get('request')->request->all();
            $em = $this->getDoctrine()->getManager();
            $tourOrder = new CustomTourOrder();
            $tourOrder->setLang($lang);
            $tourOrder->setAddInfo($lang);
            $tourOrder->setStatus(0);
            $fromCountry = $data['fromCountry'];
            $toCityId = $data['toCity'];
            $toCity = $em->getRepository('Netcast\Urest\MainBundle\Entity\City')->find($toCityId);
            $toCountry = $toCity->getRegion()->getCountry();
            if(isset($data['isApartment'])) {
                $apartmentId = $data['apartment'];
                $apartment = $em->getRepository('Netcast\Urest\MainBundle\Entity\Apartment')->find($apartmentId);
                $tourOrder->setApartment($apartment);
            } else {
                $roomId = $data['room'];
                $hotelRoom = $em->getRepository('Netcast\Urest\MainBundle\Entity\HotelRoom')->find($roomId);
                $tourOrder->setRoom($hotelRoom);
            }

            $dateStart = new \DateTime($data['dateStart']);
            $dateEnd = new \DateTime($data['dateEnd']);
            $createDate = new \DateTime();
            $tourOrder->setDateStart($dateStart);
            $tourOrder->setDateEnd($dateEnd);
            $tourOrder->setCreated($createDate);
            $tourOrder->setFromCountry($fromCountry);
            $tourOrder->setToCity($toCity);
            $tourOrder->setPrice(0);
            $tourOrder->setPrePay(0);
            $tourOrder->setIsCancel(0);
            $tourOrder->setToCountry($toCountry);
            $tourOrder->setAuthor($this->getUser());
            if(!empty($data['services'])) {
                foreach($data['services'] as $service) {
                    if(isset($service['id'])) {
                        $serviceObj = $em->getRepository('Netcast\Urest\MainBundle\Entity\Service')->find($service['id']);
                        $tourServices = new CustomTourServices();
                        $tourServices->setService($serviceObj);
                        $tourServices->setTour($tourOrder);
                        if(isset($service['reservation'])) {
                            $range = explode('-',$service['reservation']);
                            $serviceDateStart = new \DateTime($range[0]);
                            $serviceDateEnd = new \DateTime($range[1]);
                            $tourServices->setDateStart($serviceDateStart);
                            $tourServices->setDateEnd($serviceDateEnd);
                        }
                        if(isset($service['option'])) {
                            $option = $em->getRepository('Netcast\Urest\MainBundle\Entity\Options')->find($service['option']);
                            $tourServices->setOption($option);
                        }
                        $tourServices->setIsCancel(0);
                        $tourServices->setIsModerated(0);
                        $tourServices->setUserApprove(1);
                        $em->persist($tourServices);
                    }
                }
            }
            $em->persist($tourOrder);
            $em->flush();
            $this->get('netcast.urest.mailer')->sendCustomTourOrderMail($tourOrder->getId());
            $response['success'] = 1;
            $response['link'] = $this->generateUrl('netcast_urest_profile_order_view', array('id' => $tourOrder->getId()));
            return new JsonResponse($response);
        }

        public function getHotelsAction()
        {
            $stars = $this->getRequest()->get('stars');
            $city = $this->getRequest()->get('city');
            $em = $this->getDoctrine()->getManager();
            $lang = $this->get('request')->getLocale();
            $hotels = $em->getRepository('Netcast\Urest\MainBundle\Entity\Hotel')->findBy(['lang' => $lang, 'stars_count' => $stars, 'city' => $city]);
            $response = [];
            if(!empty($hotels)) {
                foreach($hotels as $key => $hotel) {
                    $response[$key]['name'] = $hotel->getTitle();
                    $response[$key]['id'] = $hotel->getId();
                }
            }
            return new JsonResponse($response);
        }

        public function getPriceAction()
        {
            $em = $this->getDoctrine()->getManager();
            $param = $this->get('request')->request->all();
            $price = 0;
            if(isset($param['services']) || !empty($param['services'])) {
                foreach ($param['services'] as $row) {
                    $type = $row['type'];
                    switch ($type) {
                        case 'line':
                            $serviceId = $row['id'];
                            $services = $em->getRepository('Netcast\Urest\MainBundle\Entity\Service')->find($serviceId);
                            $price += $services->getPrice();
                            break;
                        case 'day':
                            $dates = explode('-', $row['date']);
                            $dateStart = new \DateTime(trim($dates[0]));
                            $dateEnd = new \DateTime(trim($dates[1]));
                            $daysCount = $dateEnd->diff($dateStart)->format("%a");
                            $serviceId = $row['id'];
                            $services = $em->getRepository('Netcast\Urest\MainBundle\Entity\Service')->find($serviceId);
                            $price += $services->getPrice() * $daysCount;
                            break;
                        case 'option':
                            $optionId = $row['option'];
                            $options = $em->getRepository('Netcast\Urest\MainBundle\Entity\Options')->find($optionId);
                            $price += $options->getPrice();
                            break;
                        case 'day_option':
                            $dates = explode('-', $row['date']);
                            $dateStart = new \DateTime(trim($dates[0]));
                            $dateEnd = new \DateTime(trim($dates[1]));
                            $daysCount = $dateEnd->diff($dateStart)->format("%a");
                            $optionId = $row['option'];
                            $options = $em->getRepository('Netcast\Urest\MainBundle\Entity\Options')->find($optionId);
                            $price += $options->getPrice() * $daysCount;
                            break;
                    }
                }
            }


            $dateStart = new \DateTime($param['tourDateStart']);
            $dateEnd = new \DateTime($param['tourDateEnd']);
            $daysCount = $dateEnd->diff($dateStart)->format("%a");
            $id = $param['homeId'];
            if($param['homeType'] == 'hotel') {
                $room = $em->getRepository('Netcast\Urest\MainBundle\Entity\HotelRoom')->find($id);
            } else {
                $room = $em->getRepository('Netcast\Urest\MainBundle\Entity\Apartment')->find($id);
            }
            $price += $room->getPrice()*$daysCount;
            $price = $this->container->get('netcast.urest.twig.price')->getPrice($price);
            $response['price'] = $price;
            return new JsonResponse($response);
        }

        public function getServicesAction()
        {
            $city = $this->getRequest()->get('city');
            $em = $this->getDoctrine()->getManager();
            $lang = $this->get('request')->getLocale();
            $services = $em->getRepository('Netcast\Urest\MainBundle\Entity\Service')->findBy(['lang' => $lang, 'city' => $city]);
            return $this->render('NetcastUrestMainBundle:Form:tourServices.html.twig',['services' => $services]);
        }

        public function getServiceOptionsAction()
        {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $options = $em->getRepository('Netcast\Urest\MainBundle\Entity\Options')->getOptionsWithImages($id);
            return $this->render('NetcastUrestMainBundle:Form:tourServiceOptions.html.twig',['options' => $options, 'type' => 'option']);
        }

        public function getServiceInfoAction()
        {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $option = $em->getRepository('Netcast\Urest\MainBundle\Entity\Service')->find($id);
            return $this->render('NetcastUrestMainBundle:Form:ServiceOptionView.html.twig',['item' => $option]);
        }

        public function getRoomInfoAction()
        {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $room = $em->getRepository('Netcast\Urest\MainBundle\Entity\HotelRoom')->find($id);
            return $this->render('NetcastUrestMainBundle:Form:ServiceOptionView.html.twig',['item' => $room]);
        }

        public function getApartmentInfoAction()
        {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $room = $em->getRepository('Netcast\Urest\MainBundle\Entity\Apartment')->find($id);
            return $this->render('NetcastUrestMainBundle:Form:ServiceOptionView.html.twig',['item' => $room]);
        }

        public function getOptionInfoAction()
        {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $option = $em->getRepository('Netcast\Urest\MainBundle\Entity\Options')->find($id);
            return $this->render('NetcastUrestMainBundle:Form:ServiceOptionView.html.twig',['item' => $option]);
        }

        public function getCityAction()
        {
            $em = $this->getDoctrine()->getManager();
            $countryId = $this->getRequest()->get('id');
            $country = $em->getRepository('Netcast\Urest\MainBundle\Entity\Country')->find($countryId);
            $lang = $this->get('request')->getLocale();

            $regions = $country->getRegions()->filter(function($region) use ($lang) {
                return $region->getLang() == $lang;
            });

            $response = [];

            foreach($regions as $region) {
                $cities = $region->getCities()->filter(function($city) use ($lang) {
                    return $city->getLang() == $lang;
                });
                foreach($cities as $city) {
                    $response[$city->getId()] = $city->getTitle();
                }
            }

            return new JsonResponse($response);
        }

        public function getHotelRoomsAction()
        {
            $id = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getManager();
            $lang = $this->get('request')->getLocale();
            $hotels = $em->getRepository('Netcast\Urest\MainBundle\Entity\HotelRoom')->findBy(['lang' => $lang, 'hotel' => $id]);
            return $this->render('NetcastUrestMainBundle:Form:tourServiceOptions.html.twig',['options' => $hotels, 'type' => 'hotel']);
        }

        public function getApartmentsListAction()
        {
            $type = $this->getRequest()->get('type');
            $roomCount = $this->getRequest()->get('roomCount');
            $city = $this->getRequest()->get('city');
            $em = $this->getDoctrine()->getManager();
            $lang = $this->get('request')->getLocale();
            $apartments = $em->getRepository('Netcast\Urest\MainBundle\Entity\Apartment')->findBy(
                [
                    'lang' => $lang,
                    'rooms_count' => $roomCount,
                    'city' => $city,
                    'types' => $type
                ]
            );
            return $this->render('NetcastUrestMainBundle:Form:tourServiceOptions.html.twig',['options' => $apartments, 'type' => 'apartment']);
        }



        public function getApartmentsAction()
        {
            $type = $this->getRequest()->get('id');
            $city = $this->getRequest()->get('city');
            $lang = $this->get('request')->getLocale();
            $em = $this->getDoctrine()->getManager();
            $apartments = $em->getRepository('Netcast\Urest\MainBundle\Entity\Apartment')->getApartmentByType($type,$city,$lang);
            $response = [];
            if(!empty($apartments)) {
                foreach($apartments as $row) {
                    $roomCount = $row->getRoomsCount();
                    if($roomCount == 'house') {
                        $roomCount = 'Дом';
                    }
                    $response[] = $roomCount;
                }
            }
            return new JsonResponse($response);
        }

    }
