<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tour
 */
class TourDates {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date_from;

    /**
     * @var \DateTime
     */
    private $date_to;

    /**
     * @var integer
     */
    private $price;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Tour
     */
    private $tour;


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
     * Set date_from
     *
     * @param \DateTime $dateFrom
     * @return TourDates
     */
    public function setDateFrom($dateFrom)
    {
        $this->date_from = $dateFrom;

        return $this;
    }

    /**
     * Get date_from
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->date_from;
    }

    /**
     * Set date_to
     *
     * @param \DateTime $dateTo
     * @return TourDates
     */
    public function setDateTo($dateTo)
    {
        $this->date_to = $dateTo;

        return $this;
    }

    /**
     * Get date_to
     *
     * @return \DateTime 
     */
    public function getDateTo()
    {
        return $this->date_to;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return TourDates
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\Tour $tour
     * @return TourDates
     */
    public function setTour(\Netcast\Urest\MainBundle\Entity\Tour $tour = null)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \Netcast\Urest\MainBundle\Entity\Tour 
     */
    public function getTour()
    {
        return $this->tour;
    }

    public function __toString()
    {
        return $this->date_from->format('Y-m-d').' - '.$this->date_to->format('Y-m-d').' - '.$this->price.' €';
    }
}
