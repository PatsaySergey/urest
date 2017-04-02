<?php

namespace Netcast\Urest\MainBundle\Mailer;

use Doctrine\ORM\EntityManager;

class EventMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EntityManager
     */
    private $em;

    private $templating;

    public function __construct(\Swift_Mailer $mailer, EntityManager $em, $templating)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;
    }

    public function sendBuyTourMail($id)
    {
        $tourOrder = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\TourOrder')->find($id);
        $user = $tourOrder->getUser();
        $tour = $tourOrder->getTourDate()->getTour();
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation of purchase of the tour')
            ->setFrom('no-reply@u-rest.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'NetcastUrestMainBundle:Mail:tour.order.html.twig',
                    ['user' => $user, 'tour' => $tour]
                ),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }

    public function sendConfirmTourMail($id)
    {
        $tour = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        $user = $tour->getAuthor();
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirm your order!')
            ->setFrom('no-reply@u-rest.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'NetcastUrestMainBundle:Mail:tour.confirm.html.twig',
                    ['user' => $user, 'tour' => $tour]
                ),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }

    public function sendPayTourMail($id)
    {
        $tour = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        $user = $tour->getAuthor();
        $message = \Swift_Message::newInstance()
            ->setSubject('Awaiting payment')
            ->setFrom('no-reply@u-rest.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'NetcastUrestMainBundle:Mail:tour.pay.html.twig',
                    ['user' => $user, 'tour' => $tour]
                ),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }

    public function sendCancelTourMail($id)
    {
        $tour = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        $user = $tour->getAuthor();
        $message = \Swift_Message::newInstance()
            ->setSubject('Order canceled')
            ->setFrom('no-reply@u-rest.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'NetcastUrestMainBundle:Mail:tour.cancel.html.twig',
                    ['user' => $user, 'tour' => $tour]
                ),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }

    public function sendCustomTourBuyMail($id)
    {
        $tour = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        $user = $tour->getAuthor();
        $message = \Swift_Message::newInstance()
            ->setSubject('Payment confirmation')
            ->setFrom('no-reply@u-rest.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'NetcastUrestMainBundle:Mail:tour.custom.order.html.twig',
                    ['user' => $user, 'tour' => $tour]
                ),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }

    public function sendCustomTourOrderMail($id)
    {
        $tour = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        $user = $tour->getAuthor();
        $message = \Swift_Message::newInstance()
            ->setSubject('Start new travel!')
            ->setFrom('no-reply@u-rest.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    'NetcastUrestMainBundle:Mail:tour.custom.new.html.twig',
                    ['user' => $user, 'tour' => $tour]
                ),
                'text/html'
            )
        ;
        return $this->mailer->send($message);
    }
}