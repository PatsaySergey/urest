<?php

    namespace Netcast\Urest\MainBundle\Controller;

    use Netcast\Urest\MainBundle\Controller\MainController as Controller;
    use Symfony\Component\HttpFoundation\Response;

    class ContactController extends Controller
    {
        public function indexAction()
        {
            $lang = $this->get('request')->getLocale();
            $contactRepository = $this->getDoctrine()->getManager()->getRepository('Netcast\Urest\MainBundle\Entity\Contact');
            $country = $contactRepository->getContactCountry($lang);
            $data = [];
            $data['countries'] = $country;
            $data['contacts'] = (isset($country[0])) ? $contactRepository->getContactByCountry($lang,$country[0]['id']) : [];
            return $this->render('NetcastUrestMainBundle:Contact:contact.html.twig', $data);
        }

        public function getOfficeAction($countryId)
        {
            $em = $this->getDoctrine()->getManager();
            $lang = $this->get('request')->getLocale();
            $country = $em->getRepository('Netcast\Urest\MainBundle\Entity\Country')->find($countryId);
            $data['countryLatLng'] = $country->getCoordinates();

            $contactRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Contact');

            $offices = $contactRepository->getContactByCountry($lang,$countryId);
            foreach($offices as $key => $office)
            {
                $officeArr[$key]['LatLng'] = explode(',',$office->getCity()->getCoordinates());
                $officeArr[$key]['icon'] = $this->getMediaUrl($office->getIcon(),'reference');
                $officeArr[$key]['title'] = $office->getAdress();
                $officeArr[$key]['description'] = $office->getDescription();
            }

            $data['offices'] = $officeArr;
            $data['officesHtml'] = $this->renderView('NetcastUrestMainBundle:Contact:ofiices_block.html.twig', ['contacts' => $offices]);
            $data['status'] = 'success';

            return new Response(json_encode($data));

        }

        private function getMediaUrl($media,$format)
        {
            $mediaService = $this->get('sonata.media.pool');
            $provider = $mediaService->getProvider($media->getProviderName());

            $format = $provider->getFormatName($media, $format);
            return $provider->generatePublicUrl($media, $format);
        }
    }
