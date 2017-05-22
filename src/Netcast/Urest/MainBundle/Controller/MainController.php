<?php

namespace Netcast\Urest\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends Controller
{
    public function indexAction()
    {
        $lang = $this->get('request')->getLocale();
        $em   = $this->getDoctrine()->getManager();

        $galleryRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\MainGallery');
        $sliders           = $galleryRepository->findBy(array(
            'lang'   => $lang,
            'active' => true,
        ));
        $data['sliders']   = $sliders;

        $servicesRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\MainBlock');
        $services           = $servicesRepository->findBy(array('lang' => $lang,));
        $data['services']   = $services;

        $postRepository    = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogPost');
        $lastPosts         = $postRepository->getLastPosts(3);
        $data['lastPosts'] = $lastPosts;

        $tourRepository    = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour');
        $lastTours         = $tourRepository->getLastTours(3);
        $data['lastTours'] = $lastTours;

        $reviewRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Review');
        $reviews          = $reviewRepository->findBy(array(
            'lang'    => $lang,
            'active'  => true,
            'on_main' => true,
            'deleted' => false,
        ));
        $data['reviews']  = $reviews;

        return $this->render('NetcastUrestMainBundle:Main:main.html.twig', $data);
    }

    public function cityAction()
    {
        $lang = $this->get('request')->getLocale();
        $em   = $this->getDoctrine()->getManager();
        $cityRepo = $em->getRepository('Netcast\Urest\MainBundle\Entity\City');
        $term = $this->get('request')->get('term');
        $result = $cityRepo->search($term,$lang);
        $response = [];
        foreach ($result as $row) {
            $response[] = [
                'label' => $row['ct'].','.$row['title'],
                'value' => [
                        'city' => $row['ci'],
                        'country' => $row['id'],
                    ]
            ];
        }
        return new JsonResponse($response);
    }
}