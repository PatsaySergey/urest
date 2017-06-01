<?php

    namespace Netcast\Urest\MainBundle\Notice;

    class AdminNotice
    {
        /**
         * @var \Netcast\Urest\MainBundle\Notice\ReviewNotice
         */
        private $ReviewNotice;

        /**
         * @var \Netcast\Urest\MainBundle\Notice\NewOrderNotice
         */
        private $NewOrderNotice;


        /**
         * @var \Netcast\Urest\MainBundle\Notice\EditOrderNotice
         */
        private $EditOrderNotice;

        public function setReviewNotice(ReviewNotice $ReviewNotice)
        {
            $this->ReviewNotice = $ReviewNotice;
        }

        public function setNewOrderNotice(NewOrderNotice $ReviewNotice)
        {
            $this->NewOrderNotice = $ReviewNotice;
        }

        public function setEditOrderNotice(EditOrderNotice $EditOrderNotice)
        {
            $this->EditOrderNotice = $EditOrderNotice;
        }

        public function setCurrentLocale($locale)
        {
            $this->ReviewNotice->setCurrentLocale($locale);
            $this->NewOrderNotice->setCurrentLocale($locale);
            $this->EditOrderNotice->setCurrentLocale($locale);
        }

        public function getReviewNotice()
        {
            $newReview = $this->ReviewNotice->getNewReview();
            $reviewNoticeArray = [];
            foreach($newReview as $key => $row)
            {
                if($key > 5) continue;

                $reviewNoticeArray[$key]['id'] = $row->getId();
                $reviewNoticeArray[$key]['review'] = $row->getReview();
                $reviewNoticeArray[$key]['created'] = $row->getCreated();
            }

            $result['count'] = count($newReview);
            $result['notice'] = $reviewNoticeArray;
            unset($newReview);
            return $result;
        }

        public function getNewOrderNotice()
        {
            $newOrders = $this->NewOrderNotice->getNewOrders();
            $newOrdersNoticeArray = [];
            foreach($newOrders as $key => $row)
            {
                if($key > 5) continue;

                $newOrdersNoticeArray[$key]['id'] = $row->getId();
                $newOrdersNoticeArray[$key]['order'] = $row->getToCountry()->getContent().', '.$row->getToCity()->getContent();
                $newOrdersNoticeArray[$key]['created'] = $row->getCreated();
            }
            $result['count'] = count($newOrders);
            $result['notice'] = $newOrdersNoticeArray;
            unset($newOrders);
            return $result;
        }

        public function getEditOrderNotice()
        {
            $newOrders = $this->EditOrderNotice->getEditOrders();
            $newOrdersNoticeArray = [];
            foreach($newOrders as $key => $row)
            {
                if($key > 5) continue;

                $newOrdersNoticeArray[$key]['id'] = $row->getId();
                $newOrdersNoticeArray[$key]['order'] = $row->getToCountry()->getTitle().', '.$row->getToCity()->getTitle();
                $newOrdersNoticeArray[$key]['created'] = $row->getCreated();
            }
            $result['count'] = count($newOrders);
            $result['notice'] = $newOrdersNoticeArray;
            unset($newOrders);
            return $result;
        }


    }