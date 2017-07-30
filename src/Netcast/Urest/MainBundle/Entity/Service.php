<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * Service
 */
class Service extends HasI18NEntity
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
     * @var string
     */
    private $price;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $options;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\City
     */
    private $city;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $service_content;

    protected $contentField = 'service_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new \Doctrine\Common\Collections\ArrayCollection();
        $this->service_content = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add service_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\ServiceContent $service_content
     * @return Service
     */
    public function addServiceContent(ServiceContent $service_content)
    {
        $this->service_content[] = $service_content;

        return $this;
    }

    /**
     * Remove service_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\ServiceContent $service_content
     */
    public function removeServiceContent(ServiceContent $service_content)
    {
        $this->service_content->removeElement($service_content);
    }

    /**
     * Get service_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiceContent()
    {
        return $this->service_content;
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
     * Set type
     *
     * @param string $type
     * @return Service
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Service
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Service
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Service
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
     * @return Service
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
     * Add options
     *
     * @param \Netcast\Urest\MainBundle\Entity\Options $options
     * @return Service
     */
    public function addOption(\Netcast\Urest\MainBundle\Entity\Options $options)
    {
        $this->options[] = $options;

        return $this;
    }

    /**
     * Remove options
     *
     * @param \Netcast\Urest\MainBundle\Entity\Options $options
     */
    public function removeOption(\Netcast\Urest\MainBundle\Entity\Options $options)
    {
        $this->options->removeElement($options);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set city
     *
     * @param \Netcast\Urest\MainBundle\Entity\City $city
     * @return Service
     */
    public function setCity(\Netcast\Urest\MainBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Netcast\Urest\MainBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Service
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


    public function __toString() {
        return $this->getContent() ? $this->getContent()->getTitle() : '';
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tours;


    /**
     * Add tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour
     *
     * @return Service
     */
    public function addTour(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour)
    {
        $this->tours[] = $tour;

        return $this;
    }

    /**
     * Remove tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour
     */
    public function removeTour(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour)
    {
        $this->tours->removeElement($tour);
    }

    /**
     * Get tours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTours()
    {
        return $this->tours;
    }

}
