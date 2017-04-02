<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * TourOrder
 */
class TourOrder
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_create;

    /**
     * @var integer
     */
    private $payed;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pay_history;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\TourDates
     */
    private $tour_date;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var string
     */
    private $lang;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pay_history = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return AboutUs
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     *
     * @return TourOrder
     */
    public function setDateCreate($dateCreate)
    {
        $this->date_create = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * Set payed
     *
     * @param integer $payed
     *
     * @return TourOrder
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;

        return $this;
    }

    /**
     * Get payed
     *
     * @return integer
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * Add payHistory
     *
     * @param \Netcast\Urest\MainBundle\Entity\PayHistory $payHistory
     *
     * @return TourOrder
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
     * Set tour_date
     *
     * @param \Netcast\Urest\MainBundle\Entity\Tourdates $tour_date
     *
     * @return TourOrder
     */
    public function setTourDate(\Netcast\Urest\MainBundle\Entity\Tourdates $tour_date = null)
    {
        $this->tour_date = $tour_date;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \Netcast\Urest\MainBundle\Entity\Tour
     */
    public function getTourDate()
    {
        return $this->tour_date;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     *
     * @return TourOrder
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return (string) $this->tour_date->getTour()->getTitle().' ['.$this->tour_date.']';
    }
}

