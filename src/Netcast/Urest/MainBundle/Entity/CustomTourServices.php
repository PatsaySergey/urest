<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * CustomTourServices
 */
class CustomTourServices
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateStart;

    /**
     * @var \DateTime
     */
    private $dateEnd;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Service
     */
    private $service;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\CustomTourOrder
     */
    private $tour;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Options
     */
    private $option;

    /**
     * @var boolean
     */
    private $isModerated;

    /**
     * @var boolean
     */
    private $isCancel;

    /**
     * @var boolean
     */
    private $userApprove;


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
     * Set userApprove
     *
     * @param boolean $userApprove
     * @return CustomTourServices
     */
    public function setUserApprove($userApprove)
    {
        $this->userApprove = $userApprove;

        return $this;
    }

    /**
     * Get userApprove
     *
     * @return boolean
     */
    public function getUserApprove()
    {
        return $this->userApprove;
    }

    /**
     * Set isCancel
     *
     * @param boolean $isCancel
     * @return CustomTourServices
     */
    public function setIsCancel($isCancel)
    {
        $this->isCancel = $isCancel;

        return $this;
    }

    /**
     * Get IsCancel
     *
     * @return boolean
     */
    public function getIsCancel()
    {
        return $this->isCancel;
    }

    /**
     * Set isModerated
     *
     * @param boolean $isModerated
     * @return CustomTourServices
     */
    public function setIsModerated($isModerated)
    {
        $this->isModerated = $isModerated;

        return $this;
    }

    /**
     * Get IsModerated
     *
     * @return boolean
     */
    public function getIsModerated()
    {
        return $this->isModerated;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     *
     * @return CustomTourServices
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
     * @return CustomTourServices
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
     * Set service
     *
     * @param \Netcast\Urest\MainBundle\Entity\Service $service
     *
     * @return CustomTourServices
     */
    public function setService(\Netcast\Urest\MainBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Netcast\Urest\MainBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour
     *
     * @return CustomTourServices
     */
    public function setTour(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour = null)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \Netcast\Urest\MainBundle\Entity\Service
     */
    public function getTour()
    {
        return $this->tour;
    }

    /**
     * Set option
     *
     * @param \Netcast\Urest\MainBundle\Entity\Options $option
     *
     * @return CustomTourServices
     */
    public function setOption(\Netcast\Urest\MainBundle\Entity\Options $option = null)
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Get option
     *
     * @return \Netcast\Urest\MainBundle\Entity\Options
     */
    public function getOption()
    {
        return $this->option;
    }

    public function __toString()
    {
        $serviceTitle = $this->getService()->getTitle();
        $title = $serviceTitle;
        $option = $this->getOption();
        if(!is_null($option)) {
            $title .= ' ('.$option->getTitle().')';
        }
        $startDate = $this->getDateStart();
        $endDate = $this->getDateEnd();
        if(!is_null($startDate)) {
            $title .= ' '.$startDate->format('Y-m-d');
        }
        if(!is_null($startDate)) {
            $title .= ' - '.$endDate->format('Y-m-d');
        }
        return $title;
    }
}

