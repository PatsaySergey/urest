<?php

namespace Netcast\Urest\MainBundle\Controller;

use Netcast\Urest\MainBundle\Controller\MainController as Controller;
use Netcast\Urest\MainBundle\Form\Type\UserFormType;
use Symfony\Component\HttpFoundation\Request;
use Netcast\Urest\MainBundle\Entity\PayHistory;
use Netcast\Urest\MainBundle\Entity\CustomTourOrder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileController extends Controller
{
    private $approvedStatus = [
        0 => 'На модерации',
        1 => 'На утверждении',
        2 => 'Ожитает оплату',
        3 => 'Просроченный',
        4 => 'Оплаченный',
    ];

    private $approvedStatusText = [
        0 => 'Заявка на обработке у менеджера',
        1 => 'Пожалуйста, подтвердите ваш заказ',
        2 => 'Пожалуйста, оплатите счет',
        3 => 'Вы просрочили оплату',
        4 => 'Заказ оплачен',
    ];

    private function getCountOrdersByStatus()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->findBy(['author' => $user->getId(), 'isCancel' => 0]);
        $status = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
        ];
        $date = new \DateTime();
        foreach($orders as $order) {
            $status[$order->getStatus()]++;
            if($order->getStatus() == 2 && $date > $order->getPayTo()) {
                $status[2]--;
                $status[3]++;
            }
        }
        $status['total'] = count($orders);
        return $status;
    }

    public function orderListAction($status)
    {
        $user = $this->getUser();
        if(empty($user)) {
            return $this->redirect($this->generateUrl('netcast_urest_main_page_default'));
        }
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->getListByStatus($user,$status);
        foreach($orders as &$order) {
            $statusText = $this->approvedStatus[$order->getStatus()];
            if($order->getStatus() == 2) {
                $date = new \DateTime();
                $statusText = ($date > $order->getPayTo()) ? $this->approvedStatus[3] : $this->approvedStatus[2];
            }
            $order->statusText = $statusText;
        }

        $data['orders'] = $orders;
        $data['status'] = $status;
        $data['counts'] = $this->getCountOrdersByStatus();
        return $this->render('NetcastUrestMainBundle:Profile:viewProfile.html.twig',$data);
    }

    public function editAction()
    {
        $user = $this->getUser();
        $form = $this->createForm(new UserFormType(), $user, [
            'method' => 'POST',
            'action' => $this->generateUrl('netcast_urest_profile_update')
        ]);

        $data = [
            'form' => $form->createView(),
        ];

        return $this->render('NetcastUrestMainBundle:Profile:editProfile.html.twig',$data);
    }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $form = $this->createForm(new UserFormType(), $user, [
            'method' => 'POST',
            'action' => $this->generateUrl('netcast_urest_profile_update')
        ]);
        $form->handleRequest($request);
        if($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('netcast_urest_profile_view'));
        }
        $data = [
            'form' => $form->createView(),
        ];
        return $this->render('NetcastUrestMainBundle:Profile:editProfile.html.twig',$data);
    }

    public function viewAction()
    {
        $user = $this->getUser();
        if(empty($user)) {
            return $this->redirect($this->generateUrl('netcast_urest_main_page_default'));
        }
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->findBy(['author' => $user->getId(), 'isCancel' => 0]);
        foreach($orders as &$order) {
            $statusText = $this->approvedStatus[$order->getStatus()];
            if($order->getStatus() == 2) {
                $date = new \DateTime();
                $statusText = ($order->getPayTo() >= $date) ? $this->approvedStatus[2] : $this->approvedStatus[3];
            }
            $order->statusText = $statusText;
        }
        $data['orders'] = $orders;
        $data['counts'] = $this->getCountOrdersByStatus();
        return $this->render('NetcastUrestMainBundle:Profile:viewProfile.html.twig',$data);
    }

    public function cancelOrderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        if(!$order || $order->getAuthor()->getId() != $this->getUser()->getId() || $order->getIsCancel() == 1) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Not found');
        }
        $order->setIsCancel(1);
        $em->persist($order);
        $em->flush();
        $this->get('netcast.urest.mailer')->sendCancelTourMail($id);
        return $this->redirect($this->generateUrl('netcast_urest_profile_view'));

    }

    public function reOrderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        if(!$order || $order->getAuthor()->getId() != $this->getUser()->getId() || $order->getIsCancel() == 1) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Not found');
        }
        $order->setStatus(0);
        $em->persist($order);
        $em->flush();
        return $this->redirect($this->generateUrl('netcast_urest_profile_view'));

    }

    public function viewOrderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        if(!$order || $order->getAuthor()->getId() != $this->getUser()->getId() || $order->getIsCancel() == 1) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Not found');
        }

        $dateStart = $order->getDateStart();
        $dateEnd = $order->getDateEnd();
        $daysCount = $dateEnd->diff($dateStart)->format("%a");

        $home = ($order->getRoom()) ? $order->getRoom() : $order->getApartment();
        $homePrice = $home->getPrice()*$daysCount;

        $router = $this->container->get('router');
        $serverUrl = $router->generate('netcast_urest_profile_order_pay');
        $domain = $this->getRequest()->getHost();
        $schema = $this->getRequest()->getScheme();
        $serverUrl = $schema.'://'.$domain.$serverUrl;
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $currentUrl = $request->getUri();

        $price = $order->getPrice();
        $prePay = $order->getPrePay();
        $preAmount = ($prePay) ? $prePay : ($price/100)*10;

        $liqPay = $this->get('LiqPay');
        $form1 = $liqPay->cnb_form(array(
            'version'        => '3',
            'amount'         => $preAmount,
            'currency'       => 'EUR',
            'server_url'     => $serverUrl,
            'result_url'     => $currentUrl,
            'description'    => 'Частичная оплата тура на сайте u-rest.com',
            'order_id'       => 'ct_'.$id,
            'sandbox'        => 1
        ),false);
        $form2 = $liqPay->cnb_form(array(
            'version'        => '3',
            'amount'         => $price,
            'server_url'     => $serverUrl,
            'result_url'     => $currentUrl,
            'currency'       => 'EUR',
            'description'    => 'Оплата тура на сайте u-rest.com',
            'order_id'       => 'ct_'.$id,
            'sandbox'        => 1
        ));

        $isOverdue = false;
        if($order->getStatus() == 2) {
            $date = new \DateTime();
            $isOverdue = ($order->getPayTo() < $date);
        }

        $data = [
            'isOverdue' => $isOverdue,
            'item' => $order,
            'form1' => $form1,
            'form2' => $form2,
            'status' => $this->approvedStatus,
            'daysCount' => $daysCount,
            'homePrice' => $homePrice,
            'statusText' => $this->approvedStatusText
        ];

        $template = (in_array($order->getStatus(),[2,3])) ? 'viewToPayOrder.html.twig' : 'viewOrder.html.twig';
        return $this->render('NetcastUrestMainBundle:Profile:'.$template,$data);
    }

    public function  approveOrderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($id);
        $Post = $this->get('request')->request->all();

        if(isset($Post['serviceToApprove'])) {
            $approveServices = $Post['serviceToApprove'];
        }
        $homeToApprove = false;
        if(isset($Post['addHomeToApprove'])) {
            $homeToApprove = $Post['addHomeToApprove'];
        }
        if($homeToApprove) {
            $home = $em->getRepository('Netcast\Urest\MainBundle\Entity\AddTourHome')->find($homeToApprove);
            if(!is_null($order->getRoom())) {
                if($home->getType() == 'hotel') {
                    $order->setRoom($home->getRoom());
                } else {
                    $order->setRoom(NULL);
                    $order->setApartment($home->getApartment());
                }
            }
            if(!is_null($order->getApartment())) {
                if($home->getType() == 'hotel') {
                    $order->setApartment(NULL);
                    $order->setRoom($home->getRoom());
                } else {
                    $order->setApartment($home->getApartment());
                }
            }
        }

        $addHomes = $order->getAddHome();
        foreach($addHomes as $addHome) {
            $order->removeAddHome($addHome);
        }

        $services = $order->getServices();
        foreach($services as $service) {
            if($service->getIsCancel()) {
                $order->removeService($service);
                $em->remove($service);
            }
            if($service->getIsModerated()) {
                if(in_array($service->getId(),$approveServices)) {
                    $service->setIsModerated(false);
                    $service->setUserApprove(true);
                } else {
                    $order->removeService($service);
                    $em->remove($service);
                }
            }
        }
        $orderPrice = $this->getTourPrice($order);
        $order->setPrice($orderPrice);
        $order->setStatus(2);
        $date = new \DateTime('+7 days');
        $order->setPayTo($date);
        $em->persist($order);
        $em->flush();
        $this->get('netcast.urest.mailer')->sendPayTourMail($id);
        return $this->redirect($this->generateUrl('netcast_urest_profile_order_view',['id' => $id]));
    }

    private function getTourPrice($order)
    {
        $dateStart = $order->getDateStart();
        $dateEnd = $order->getDateEnd();
        $daysCount = $dateEnd->diff($dateStart)->format("%a");

        $home = ($order->getRoom()) ? $order->getRoom() : $order->getApartment();
        $totalPrice = $home->getPrice()*$daysCount;

        $services = $order->getServices();
        foreach($services as $service) {
            $totalPrice += $this->getServicePrice($service);
        }
        return $totalPrice;
    }

    private function getServicePrice($tourService)
    {
        $price = 0;
        $serviceType = $tourService->getService()->getType();
        switch($serviceType) {
            case 'line':
                $price = $tourService->getService()->getPrice();
                break;
            case 'day':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $price = $tourService->getService()->getPrice()*$daysCount;
                break;
            case 'day_option':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $option = $tourService->getOption();
                if(!empty($option)) {
                    $price = $option->getPrice()*$daysCount;
                }
                break;
            case 'option':
                $option = $tourService->getOption();
                if(!empty($option)){
                    $price = $option->getPrice();
                }
                break;
        }
        return $price;
    }

}
