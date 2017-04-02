<?php

namespace Netcast\Urest\MainBundle\Controller;

use Netcast\Urest\MainBundle\Controller\MainController as Controller;

class HelpController extends Controller
{
    public function indexAction()
    {
        $lang = $this->get('request')->getLocale();
        $em = $this->getDoctrine()->getManager();
        $locationInfoPosts = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->findCountries(['lang' => $lang]);
        $data = ['locationInfoPosts' => $locationInfoPosts];
        return $this->render('NetcastUrestMainBundle:Help:list.html.twig', $data);
    }

    public function viewAction($id)
    {
        $lang = $this->get('request')->getLocale();
        $em = $this->getDoctrine()->getManager();
        $locationInfoPost = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->find($id);
        $locationInfoChilds = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->getChildrenByLang($lang,$id);
        $tours = $this->getHelpTours($lang);
        $data = [
            'locationInfoPost' => $locationInfoPost,
            'locationInfoChilds' => $locationInfoChilds,
            'currCity' => null,
            'tours' => $tours
        ];
        return $this->render('NetcastUrestMainBundle:Help:help.html.twig', $data);
    }

    public function viewCityAction($id)
    {
        $lang = $this->get('request')->getLocale();
        $em = $this->getDoctrine()->getManager();
        $locationInfoPost = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->find($id);
        $parentId = $locationInfoPost->getParent()->getId();
        $locationInfoChilds = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->getChildrenByLang($lang,$parentId);

        $tours = $this->getHelpTours($lang);

        $data = [
            'locationInfoPost' => $locationInfoPost,
            'locationInfoChilds' => $locationInfoChilds,
            'currCity' => $id,
            'tours' => $tours
        ];
        return $this->render('NetcastUrestMainBundle:Help:help.html.twig', $data);
    }

    private function getHelpTours($lang)
    {
        $em = $this->getDoctrine()->getManager();
        $tourRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour');
        return $tourRepository->getAllTours($lang, null, 0, 4);
    }

}
