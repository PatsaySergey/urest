<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * CustomTourOrder
 */
class CustomTourOrder
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $fromCountry;

    /**
     * @var \DateTime
     */
    private $dateStart;

    /**
     * @var \DateTime
     */
    private $dateEnd;

    /**
     * @var string
     */
    private $addInfo;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var float
     */
    private $price;

    /**
     * @var boolean
     */
    private $isCancel = 0;

    /**
     * @var float
     */
    private $prePay;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $payTo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $services;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $add_home;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pay_history;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Country
     */
    private $toCountry;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\City
     */
    private $toCity;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\HotelRoom
     */
    private $room;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Apartment
     */
    private $apartment;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $author;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $moderator;


    private $tourPrice = 0;
    private $daysCount = 0;

    private $isPayed;

    public function setIsPayed($isPayed)
    {
        $this->isPayed = $isPayed;
        return $this;
    }

    public function getIsPayed()
    {
        return $this->isPayed;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
        $this->add_home = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pay_history = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function makePrice()
    {
        $this->setDaysCount();
        $this->setBatPrice();
        foreach($this->getServices() as $tourService) {
            $serviceType = $tourService->getService()->getType();
            $this->addServicePrice($tourService,$serviceType);
            $tourService->setTour($this);
        }
        return $this->tourPrice;
    }

    private function addServicePrice($tourService,$serviceType)
    {
        switch($serviceType) {
            case 'line':
                $this->tourPrice += $tourService->getService()->getPrice();
                break;
            case 'day':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $this->tourPrice += $tourService->getService()->getPrice()*$daysCount;
                break;
            case 'day_option':
                $dateStart = $tourService->getDateStart();
                $dateEnd = $tourService->getDateEnd();
                $daysCount = $dateEnd->diff($dateStart)->format("%a");
                $option = $tourService->getOption();
                if(!empty($option)) {
                    $this->tourPrice += $option->getPrice()*$daysCount;
                }
                break;
            case 'option':
                $option = $tourService->getOption();
                if(!empty($option)){
                    $this->tourPrice += $option->getPrice();
                }
                break;
        }
    }

    private function setBatPrice()
    {
        $room = $this->getRoom();
        if(!empty($room)) {
            $this->tourPrice += $this->daysCount*$room->getPrice();
        }
        $apartment = $this->getApartment();
        if(!empty($apartment)) {
            $this->tourPrice += $this->daysCount*$apartment->getPrice();
        }
    }

    private function setDaysCount()
    {
        $dateStart = $this->getDateStart();
        $dateEnd = $this->getDateEnd();
        $this->daysCount = $dateEnd->diff($dateStart)->format("%a");
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return CustomTourOrder
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set fromCountry
     *
     * @param string $fromCountry
     *
     * @return CustomTourOrder
     */
    public function setFromCountry($fromCountry)
    {
        $this->fromCountry = $fromCountry;

        return $this;
    }

    /**
     * Get fromCountry
     *
     * @return string
     */
    public function getFromCountry()
    {
        return $this->fromCountry;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return CustomTourOrder
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     *
     * @return CustomTourOrder
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set addInfo
     *
     * @param string $addInfo
     *
     * @return CustomTourOrder
     */
    public function setAddInfo($addInfo)
    {
        $this->addInfo = $addInfo;

        return $this;
    }

    /**
     * Get addInfo
     *
     * @return string
     */
    public function getAddInfo()
    {
        return $this->addInfo;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CustomTourOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return CustomTourOrder
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isCancel
     *
     * @param boolean $isCancel
     *
     * @return CustomTourOrder
     */
    public function setIsCancel($isCancel)
    {
        $this->isCancel = $isCancel;

        return $this;
    }

    /**
     * Get isCancel
     *
     * @return boolean
     */
    public function getIsCancel()
    {
        return $this->isCancel;
    }

    /**
     * Set prePay
     *
     * @param float $prePay
     *
     * @return CustomTourOrder
     */
    public function setPrePay($prePay)
    {
        $this->prePay = $prePay;

        return $this;
    }

    /**
     * Get prePay
     *
     * @return float
     */
    public function getPrePay()
    {
        return $this->prePay;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return CustomTourOrder
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set payTo
     *
     * @param \DateTime $payTo
     *
     * @return CustomTourOrder
     */
    public function setPayTo($payTo)
    {
        $this->payTo = $payTo;

        return $this;
    }

    /**
     * Get payTo
     *
     * @return \DateTime
     */
    public function getPayTo()
    {
        return $this->payTo;
    }

    /**
     * Add service
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourServices $service
     *
     * @return CustomTourOrder
     */
    public function addService(\Netcast\Urest\MainBundle\Entity\CustomTourServices $service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Remove service
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourServices $service
     */
    public function removeService(\Netcast\Urest\MainBundle\Entity\CustomTourServices $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Add addHome
     *
     * @param \Netcast\Urest\MainBundle\Entity\AddTourHome $addHome
     *
     * @return CustomTourOrder
     */
    public function addAddHome(\Netcast\Urest\MainBundle\Entity\AddTourHome $addHome)
    {
        $this->add_home[] = $addHome;

        return $this;
    }

    /**
     * Remove addHome
     *
     * @param \Netcast\Urest\MainBundle\Entity\AddTourHome $addHome
     */
    public function removeAddHome(\Netcast\Urest\MainBundle\Entity\AddTourHome $addHome)
    {
        $this->add_home->removeElement($addHome);
    }

    /**
     * Get addHome
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddHome()
    {
        return $this->add_home;
    }

    /**
     * Add payHistory
     *
     * @param \Netcast\Urest\MainBundle\Entity\PayHistory $payHistory
     *
     * @return CustomTourOrder
     */
    public function addPayHistory(\Netcast\Urest\MainBundle\Entity\PayHistory $payHistory)
    {
        $this->pay_history[] = $payHistory;

        return $this;
    }

    /**
     * Remove payHistory
     *
     * @param \Netcast\Urest\MainBundle\Entity\PayHistory $payHistory
     */
    public function removePayHistory(\Netcast\Urest\MainBundle\Entity\PayHistory $payHistory)
    {
        $this->pay_history->removeElement($payHistory);
    }

    /**
     * Get payHistory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayHistory()
    {
        return $this->pay_history;
    }

    /**
     * Set toCountry
     *
     * @param \Netcast\Urest\MainBundle\Entity\Country $toCountry
     *
     * @return CustomTourOrder
     */
    public function setToCountry(\Netcast\Urest\MainBundle\Entity\Country $toCountry = null)
    {
        $this->toCountry = $toCountry;

        return $this;
    }

    /**
     * Get toCountry
     *
     * @return \Netcast\Urest\MainBundle\Entity\Country
     */
    public function getToCountry()
    {
        return $this->toCountry;
    }

    /**
     * Set toCity
     *
     * @param \Netcast\Urest\MainBundle\Entity\City $toCity
     *
     * @return CustomTourOrder
     */
    public function setToCity(\Netcast\Urest\MainBundle\Entity\City $toCity = null)
    {
        $this->toCity = $toCity;

        return $this;
    }

    /**
     * Get toCity
     *
     * @return \Netcast\Urest\MainBundle\Entity\City
     */
    public function getToCity()
    {
        return $this->toCity;
    }

    /**
     * Set room
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelRoom $room
     *
     * @return CustomTourOrder
     */
    public function setRoom(\Netcast\Urest\MainBundle\Entity\HotelRoom $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \Netcast\Urest\MainBundle\Entity\HotelRoom
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set apartment
     *
     * @param \Netcast\Urest\MainBundle\Entity\Apartment $apartment
     *
     * @return CustomTourOrder
     */
    public function setApartment(\Netcast\Urest\MainBundle\Entity\Apartment $apartment = null)
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * Get apartment
     *
     * @return \Netcast\Urest\MainBundle\Entity\Apartment
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * Set author
     *
     * @param \Application\Sonata\UserBundle\Entity\User $author
     *
     * @return CustomTourOrder
     */
    public function setAuthor(\Application\Sonata\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set moderator
     *
     * @param \Application\Sonata\UserBundle\Entity\User $moderator
     *
     * @return CustomTourOrder
     */
    public function setModerator(\Application\Sonata\UserBundle\Entity\User $moderator = null)
    {
        $this->moderator = $moderator;

        return $this;
    }

    /**
     * Get moderator
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getModerator()
    {
        return $this->moderator;
    }

    public function __toString()
    {
        return $this->toCountry->getContent()->getTitle().' - '.$this->toCity->getContent()->getTitle();
    }
}

