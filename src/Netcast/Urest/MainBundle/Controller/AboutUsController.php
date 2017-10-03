<?php

    namespace Netcast\Urest\MainBundle\Controller;

    use Netcast\Urest\MainBundle\Controller\MainController as Controller;
    use Netcast\Urest\MainBundle\Entity\Review;
    use Netcast\Urest\MainBundle\Form\Type\ReviewFormType;

    class AboutUsController extends Controller
    {
        public function indexAction()
        {
            $formBuilder = $this->createForm(new ReviewFormType());
            $data = [];
            $data['form'] = $formBuilder->createView();

            $em = $this->getDoctrine()->getManager();
            $lang = $this->getRequest()->getLocale();
            $aboutPosts = $em->getRepository('Netcast\Urest\MainBundle\Entity\AboutUs')->find(1);

            $partnersRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Partner');
            $partners = $partnersRepository->findBy(['lang' => $lang],[],4,0);
            $data['partners'] = $partners;

            $reviewRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Review');
            $reviews = $reviewRepository->findBy(['lang' => $lang, 'active' => true, 'deleted' => false],['created' => 'DESC'],3,0);
            $data['reviews'] = $reviews;


            $data['aboutPost'] = $aboutPosts;

            return $this->render('NetcastUrestMainBundle:AboutUs:about_as.html.twig', $data);
        }

        public function addReviewAction()
        {
            $request = $this->getRequest();
            $review = new Review();
            $formBuilder = $this->createForm(new ReviewFormType(),$review);

            if($request->getMethod() === 'POST')
            {
                $formBuilder->bind($request);
                if($formBuilder->isValid())
                {
                    $em = $this->getDoctrine()->getManager();
                    $review->setLang($request->getLocale());
                    $review->setUser($this->getUser());
                    $review->setActive(0);
                    $em->persist($review);
                    $em->flush();
                    return $this->redirect($this->generateUrl('netcast_urest_about_as_view'));
                }
                else
                {
                    $data['form'] = $formBuilder->createView();
                    $em = $this->getDoctrine()->getManager();
                    $lang = $this->getRequest()->getLocale();
                    $aboutPosts = $em->getRepository('Netcast\Urest\MainBundle\Entity\AboutUs')->findBy(['lang' => $lang],[],1,0);

                    $partnersRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Partner');
                    $partners = $partnersRepository->findBy(['lang' => $lang],[],4,0);
                    $data['partners'] = $partners;

                    $reviewRepository = $em->getRepository('Netcast\Urest\MainBundle\Entity\Review');
                    $reviews = $reviewRepository->findBy(['lang' => $lang, 'active' => true, 'deleted' => false],['created' => 'DESC'],3,0);
                    $data['reviews'] = $reviews;


                    if(isset($aboutPosts[0])) {
                        $data['aboutPost'] = $aboutPosts[0];
                    }
                    return $this->render('NetcastUrestMainBundle:AboutUs:about_as.html.twig', $data);
                }
            }

        }
    }
