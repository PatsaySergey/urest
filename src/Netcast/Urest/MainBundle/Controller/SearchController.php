<?php

namespace Netcast\Urest\MainBundle\Controller;

use Netcast\Urest\MainBundle\Controller\MainController as Controller;

class SearchController extends Controller
{
    public function indexAction()
    {
        $lang = $this->get('request')->getLocale();
        $em = $this->getDoctrine()->getManager();
        $get = $this->get('request')->query->all();
        $search = (isset($get['search'])) ? $get['search'] : false;
        $type = (isset($get['type'])) ? $get['type'] : false;

        $postRepository = [];
        $tourRepository = [];
        $infoRepository = [];

        switch($type) {
            case 'tour':
                $tourRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour')->searchTours($lang,$search);
                break;
            case 'blog':
                $postRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogPost')->searchPosts($lang, $search);
                break;
            case 'info':
                $infoRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->searchCountries($lang,$search);
                break;
            default:
                $postRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\BlogPost')->searchPosts($lang, $search);
                $tourRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Tour')->searchTours($lang,$search);
                $infoRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\LocationInfo')->searchCountries($lang,$search);
                break;
        }

        $allResults = [];

        if(!empty($postRepository)) {
            foreach($postRepository as $post) {
                $item['type'] = 'blog';
                $item['date'] = $post->getCreated()->format('Y-m-d');
                $item['title'] = 'БЛОГ';
                $item['item'] = $post;
                $item['icon'] = 'fa-comment-o';
                $allResults[] = $item;
            }
        }

        if(!empty($tourRepository)) {
            foreach($tourRepository as $tour) {
                $item['type'] = 'tour';
                $item['date'] = $tour->getCreated()->format('Y-m-d');
                $item['item'] = $tour;
                $item['title'] = 'ТУР';
                $item['icon'] = 'fa-suitcase';
                $allResults[] = $item;
            }
        }

        if(!empty($infoRepository)) {
            foreach($infoRepository as $info) {
                if(!is_null($info->getParent())) {
                    $item['type'] = 'city';
                    $item['title'] = 'ГОРОД';
                } else {
                    $item['type'] = 'country';
                    $item['title'] = 'СТРАНА';
                }
                $item['icon'] = 'fa-map-marker';
                $item['date'] = $info->getCreated()->format('Y-m-d');
                $item['item'] = $info;
                $allResults[] = $item;
            }
        }
        $datesArray = [];
        foreach($allResults as $key => $row){
            $datesArray[$key] = $row['date'];
        }
        array_multisort($datesArray, SORT_DESC, $allResults);
        return $this->render('NetcastUrestMainBundle:Search:list.html.twig', [
            'allResults' => $allResults,
        ]);
    }

}
