<?php

namespace Netcast\Urest\MainBundle\Controller;

use Netcast\Urest\MainBundle\Controller\MainController as Controller;

use Netcast\Urest\MainBundle\Entity\TourOrder;
use Netcast\Urest\MainBundle\Entity\PayOrders;

class TourController extends Controller
{

    private function buildMapOptions($tours)
    {
        $result = [];
        $result['type'] = 'tour';
        $result['items'] = [];
        foreach($tours as $post) {
            $item = [];
            $coordinates = explode(',',$post->getCoordinates());
            $item['title'] = $post->getContent()->getTitle();
            $item['description'] = $post->getContent()->getDescription();
            $item['accommodation'] = $post->getContent()->getAccommodation();
            $tourImages = $post->getTourImages();
            foreach($tourImages as $row) {
                if($row->getMain()) {
                    $provider = $this->container->get($row->getMedia()->getProviderName());
                    $item['img'] = $provider->generatePublicUrl($row->getMedia(), 'reference');
                }
            }
            $item['url'] = $this->generateUrl('netcast_urest_tour_view',['id' => $post->getId()]);
            $mapIcon = $post->getIcon();
            if($mapIcon) {
                $provider = $this->container->get($mapIcon->getProviderName());
                $iconUrl = $provider->generatePublicUrl($mapIcon,'reference');
                $item['icon'] = $iconUrl;
            }

            if(count($coordinates) == 2) {
                $item['lat'] = $coordinates[0];
                $item['lng'] = $coordinates[1];
                $result['items'][] = $item;
            }
        }
        return json_encode($result);
    }


    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tourCountry = $this->getRequest()->get('tourCountry');
        $tourCity = $this->getRequest()->get('tourCity');

        if(!empty($tourCountry) && empty($tourCity)) {
            $countryRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Country');
            $country = $countryRepository->find($tourCountry);
            if(!empty($country)) {
                foreach($country->getRegions() as $region) {
                    foreach($region->getCities() as $city) {
                        $tourCity[$city->getId()] = $city->getId();
                    }
                }
            }
        }

        $tourRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour');
        $tours = $tourRepository->getAllTours($tourCity, 0, 8);
        $data['tours'] = $tours;

        $mapOptions = $this->buildMapOptions($tours);

        $cities = $tourRepository->getTourCities();
        $tourCountries = [];
        $tourCities = [];
        foreach($cities as $row) {
            $city = $row->getCity();
            $country = $city->getRegion()->getCountry();
            $tourCountries[$country->getId()] = $country;
            $tourCities[$city->getId()] = $city;
        }
        $data['mapOptions'] = $mapOptions;
        $data['tourCountries'] = $tourCountries;
        $data['tourCities'] = $tourCities;

        return $this->render('NetcastUrestMainBundle:Tour:list.html.twig', $data);
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tourRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour');
        $tour = $tourRepository->findOneBy(['id' => $id]);
        $tourAdd = $tourRepository->findBy(['city' => $tour->getCity()->getId()],null,5);
        foreach($tourAdd as $key => $row) {
            if($row->getId() == $id) {
                unset($tourAdd[$key]);
            }
        }
        $data['tour'] = $tour;
        $data['tourAdd'] = $tourAdd;
        return $this->render('NetcastUrestMainBundle:Tour:tour.html.twig', $data);
    }

    public function getPriceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tourRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\TourDates');
        $tour = $tourRepository->find($id);
        $price = $this->container->get('netcast.urest.twig.price')->getPrice($tour->getPrice());
        echo $price;
        die();
    }

    public function payAction($id)
    {
        if($this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $tourDate = $em->getRepository('Netcast\Urest\MainBundle\Entity\TourDates')->find($id);
            $tourOrder = new TourOrder();
            $tourOrder->setDateCreate(new \DateTime());
            $tourOrder->setUser($this->getUser());
            $tourOrder->setTourDate($tourDate);
            $tourOrder->setLang($this->get('request')->getLocale());
            $tourOrder->setPayed(0);
            $em->persist($tourOrder);
            $em->flush();

            $router = $this->container->get('router');
            $serverUrl = $router->generate('netcast_urest_profile_tour_order_pay');
            $domain = $this->getRequest()->getHost();
            $schema = $this->getRequest()->getScheme();
            $serverUrl = $schema.'://'.$domain.$serverUrl;

            $amount = $tourDate->getPrice();

            $liqPay = $this->get('LiqPay');
            $response = $liqPay->cnb_form(array(
                'version'        => '3',
                'amount'         => $amount,
                'currency'       => 'EUR',
                'server_url'     => $serverUrl,
                'result_url'     => $schema.'://'.$domain.$router->generate('netcast_urest_profile_view'),
                'description'    => 'Оплата тура на сайте u-rest.com',
                'order_id'       => 't_'.$tourOrder->getId(),
                'sandbox'        => 1
            ),false);
            echo $response;
            die();
        }
    }

}
