<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * AddTourHome
 */
class AddTourHome
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\HotelRoom
     */
    private $room;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Apartment
     */
    private $apartment;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\CustomTourOrder
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
     * Set type
     *
     * @param string $type
     *
     * @return AddTourHome
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set room
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelRoom $room
     *
     * @return AddTourHome
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
     * @return AddTourHome
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
     * Set tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour
     *
     * @return AddTourHome
     */
    public function setTour(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour = null)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \Netcast\Urest\MainBundle\Entity\CustomTourOrder
     */
    public function getTour()
    {
        return $this->tour;
    }
}

