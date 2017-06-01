<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 */
class Region extends HasI18NEntity
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
    private $cities;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Country
     */
    private $country;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $region_content;

    protected $contentField = 'region_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->region_content = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add region_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\RegionContent $region_content
     * @return Region
     */
    public function addRegionContent(\Netcast\Urest\MainBundle\Entity\RegionContent $region_content)
    {
        $this->region_content[] = $region_content;

        return $this;
    }

    /**
     * Remove region_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\RegionContent $region_content
     */
    public function removeRegionContent(\Netcast\Urest\MainBundle\Entity\RegionContent $region_content)
    {
        $this->region_content->removeElement($region_content);
    }

    /**
     * Get region_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegionContent()
    {
        return $this->region_content;
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
     * @return Region
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
     * @return Region
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
     * @return Region
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
     * Add cities
     *
     * @param \Netcast\Urest\MainBundle\Entity\City $cities
     * @return Region
     */
    public function addCity(\Netcast\Urest\MainBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Netcast\Urest\MainBundle\Entity\City $cities
     */
    public function removeCity(\Netcast\Urest\MainBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Set country
     *
     * @param \Netcast\Urest\MainBundle\Entity\Country $country
     * @return Region
     */
    public function setCountry(\Netcast\Urest\MainBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Netcast\Urest\MainBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Region
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
