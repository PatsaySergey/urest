<?php

namespace Netcast\Urest\MainBundle\Controller;

use Netcast\Urest\MainBundle\Controller\MainController as Controller;
use Netcast\Urest\MainBundle\Entity\CustomTourOrder;
use Netcast\Urest\MainBundle\Entity\PayHistory;
use Netcast\Urest\MainBundle\Entity\TourOrder;

class PayController extends Controller
{
    public function payOrderAction()
    {
        $liqPay = $this->get('LiqPay');

        $data = $this->get('request')->request->get('data');
        $dataArray = (array) json_decode(base64_decode($data));
        $signature = $this->get('request')->request->get('signature');
        $buildSign = $liqPay->cnb_signature($dataArray);
        $em = $this->getDoctrine()->getManager();
        $orderId = $dataArray['order_id'];
        $ctId = explode('_',$orderId)[1];
        $ctOrder = $em->getRepository('Netcast\Urest\MainBundle\Entity\CustomTourOrder')->find($ctId);
        if($ctOrder instanceof CustomTourOrder) {
            $user = $ctOrder->getAuthor();
        } else {
            $user = null;
        }

        if($dataArray['status'] == 'sandbox') {
            $ctOrder->setIsPayed(1);
            $ctOrder->setStatus(4);
            $this->get('netcast.urest.mailer')->sendCustomTourBuyMail($ctId);
        }

        $history = new PayHistory();
        $history->setAmount((isset($dataArray['amount'])) ? $dataArray['amount'] : 123);
        $history->setUser($user);
        $history->setSign($signature);
        $history->setSignSys($buildSign);
        $history->setData($data);
        $history->setCreated(new \DateTime());
        $history->setStatus($dataArray['status']);
        $history->setOrder($ctOrder);
        $em->persist($history);
        $em->flush();
        $ctOrder->addPayHistory($history);
        $em->persist($ctOrder);
        $em->flush();
        die();
    }

    public function payTourAction()
    {
        $liqPay = $this->get('LiqPay');

        $data = $this->get('request')->request->get('data');
        $dataArray = (array) json_decode(base64_decode($data));
        $signature = $this->get('request')->request->get('signature');
        $buildSign = $liqPay->cnb_signature($dataArray);
        $em = $this->getDoctrine()->getManager();
        $orderId = $dataArray['order_id'];
        $tId = explode('_',$orderId)[1];
        $tOrder = $em->getRepository('Netcast\Urest\MainBundle\Entity\TourOrder')->find($tId);

        if($tOrder instanceof TourOrder) {
            $user = $tOrder->getUser();
        } else {
            $user = null;
        }

        if($dataArray['status'] == 'sandbox') {
            $tOrder->setPayed(1);
            $this->get('netcast.urest.mailer')->sendBuyTourMail($tId);
        }

        $em = $this->getDoctrine()->getManager();
        $history = new PayHistory();
        $history->setAmount((isset($dataArray['amount'])) ? $dataArray['amount'] : 123);
        $history->setUser($user);
        $history->setSign($signature);
        $history->setSignSys($buildSign);
        $history->setStatus($dataArray['status']);
        $history->setData($data);
        $history->setCreated(new \DateTime());
        $history->setTourOrder($tOrder);
        $em->persist($history);
        $em->flush();
        $tOrder->addPayHistory($history);
        $em->persist($tOrder);
        $em->flush();
        die();
    }

}
