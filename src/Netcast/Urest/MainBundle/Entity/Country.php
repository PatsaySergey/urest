<?php

namespace Netcast\Urest\MainBundle\Entity;


/**
 * Country
 */
class Country extends HasI18NEntity
{
    /**
     * @var integer
     */
    private $id;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $regions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $country_content;

    protected $contentField = 'country_content';

    /**1
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->country_content = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set coordinates
     *
     * @param string $coordinates
     * @return Country
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
     * @return Country
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
     * @return Country
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
     * Add regions
     *
     * @param \Netcast\Urest\MainBundle\Entity\Region $regions
     * @return Country
     */
    public function addRegion(\Netcast\Urest\MainBundle\Entity\Region $regions)
    {
        $this->regions[] = $regions;

        return $this;
    }

    /**
     * Remove regions
     *
     * @param \Netcast\Urest\MainBundle\Entity\Region $regions
     */
    public function removeRegion(\Netcast\Urest\MainBundle\Entity\Region $regions)
    {
        $this->regions->removeElement($regions);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRegions()
    {
        return $this->regions;
    }


    /**
     * Add country_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\CountryContent $country_content
     * @return Country
     */
    public function addCountryContent(\Netcast\Urest\MainBundle\Entity\CountryContent $country_content)
    {
        $this->country_content[] = $country_content;

        return $this;
    }

    /**
     * Remove country_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\CountryContent $country_content
     */
    public function removeCountryContent(\Netcast\Urest\MainBundle\Entity\CountryContent $country_content)
    {
        $this->country_content->removeElement($country_content);
    }

    /**
     * Get country_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCountryContent()
    {
        return $this->country_content;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Country
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

}
