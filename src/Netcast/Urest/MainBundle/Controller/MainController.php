<?php

namespace Netcast\Urest\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $lastPosts         = $postRepository->getLastPosts($lang, 3);
        $data['lastPosts'] = $lastPosts;

        $tourRepository    = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour');
        $lastTours         = $tourRepository->getLastTours($lang, 3);
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
}