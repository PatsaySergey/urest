<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 */
class City
{
    public function __toString() {
        return $this->title ?: '';
    }
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
    private $title;

    /**
     * @var string
     */
    private $coordinates;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Region
     */
    private $region;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


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
     * @return City
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
     * Set title
     *
     * @param string $title
     * @return City
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set coordinates
     *
     * @param string $coordinates
     * @return City
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string 
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return City
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return City
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set region
     *
     * @param \Netcast\Urest\MainBundle\Entity\Region $region
     * @return City
     */
    public function setRegion(\Netcast\Urest\MainBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Netcast\Urest\MainBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return City
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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tour;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tour = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\Tour $tour
     * @return City
     */
    public function addTour(\Netcast\Urest\MainBundle\Entity\Tour $tour)
    {
        $this->tour[] = $tour;

        return $this;
    }

    /**
     * Remove tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\Tour $tour
     */
    public function removeTour(\Netcast\Urest\MainBundle\Entity\Tour $tour)
    {
        $this->tour->removeElement($tour);
    }

    /**
     * Get tour
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTour()
    {
        return $this->tour;
    }

    /**
     * @var boolean
     */
    private $in_builder;


    /**
     * Set in_builder
     *
     * @param boolean $inBuilder
     * @return City
     */
    public function setInBuilder($inBuilder)
    {
        $this->in_builder = $inBuilder;

        return $this;
    }

    /**
     * Get in_builder
     *
     * @return boolean 
     */
    public function getInBuilder()
    {
        return $this->in_builder;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $apartments;


    /**
     * Add apartments
     *
     * @param \Netcast\Urest\MainBundle\Entity\Apartment $apartments
     * @return City
     */
    public function addApartment(\Netcast\Urest\MainBundle\Entity\Apartment $apartments)
    {
        $this->apartments[] = $apartments;

        return $this;
    }

    /**
     * Remove apartments
     *
     * @param \Netcast\Urest\MainBundle\Entity\Apartment $apartments
     */
    public function removeApartment(\Netcast\Urest\MainBundle\Entity\Apartment $apartments)
    {
        $this->apartments->removeElement($apartments);
    }

    /**
     * Get apartments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApartments()
    {
        return $this->apartments;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tours;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $contacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $services;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $hotels;


    /**
     * Get tours
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTours()
    {
        return $this->tours;
    }

    /**
     * Add contacts
     *
     * @param \Netcast\Urest\MainBundle\Entity\Contact $contacts
     * @return City
     */
    public function addContact(\Netcast\Urest\MainBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \Netcast\Urest\MainBundle\Entity\Contact $contacts
     */
    public function removeContact(\Netcast\Urest\MainBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add services
     *
     * @param \Netcast\Urest\MainBundle\Entity\Service $services
     * @return City
     */
    public function addService(\Netcast\Urest\MainBundle\Entity\Service $services)
    {
        $this->services[] = $services;

        return $this;
    }

    /**
     * Remove services
     *
     * @param \Netcast\Urest\MainBundle\Entity\Service $services
     */
    public function removeService(\Netcast\Urest\MainBundle\Entity\Service $services)
    {
        $this->services->removeElement($services);
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
     * Add hotels
     *
     * @param \Netcast\Urest\MainBundle\Entity\Hotel $hotels
     * @return City
     */
    public function addHotel(\Netcast\Urest\MainBundle\Entity\Hotel $hotels)
    {
        $this->hotels[] = $hotels;

        return $this;
    }

    /**
     * Remove hotels
     *
     * @param \Netcast\Urest\MainBundle\Entity\Hotel $hotels
     */
    public function removeHotel(\Netcast\Urest\MainBundle\Entity\Hotel $hotels)
    {
        $this->hotels->removeElement($hotels);
    }

    /**
     * Get hotels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHotels()
    {
        return $this->hotels;
    }
}
