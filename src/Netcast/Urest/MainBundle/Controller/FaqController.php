<?php

namespace Netcast\Urest\MainBundle\Controller;

use Netcast\Urest\MainBundle\Controller\MainController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Netcast\Urest\MainBundle\Entity\Faq;
use Netcast\Urest\MainBundle\Form\Type\FaqFormType;

class FaqController extends Controller
{
    public function listAction(Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $lang           = $request->getLocale();
        $postRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Faq');
        $faqs           = $postRepository->findBy(array(
            'lang'   => $lang,
            'active' => 1,
        ));
        //$formBuilder = $this->createForm(new FaqFormType());
        //$data['form'] = $formBuilder->createView();
        return $this->render('NetcastUrestMainBundle:Faq:faq.html.twig', array(
            'faqs' => $faqs
        ));
    }
}