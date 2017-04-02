<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationInfoImage
 */
class LocationInfoImage
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $main;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\LocationInfo
     */
    private $location_info;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $media;


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
     * Set main
     *
     * @param boolean $main
     * @return LocationInfoImage
     */
    public function setMain($main)
    {
        $this->main = $main;

        return $this;
    }

    /**
     * Get main
     *
     * @return boolean 
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * Set location_info
     *
     * @param \Netcast\Urest\MainBundle\Entity\LocationInfo $locationInfo
     * @return LocationInfoImage
     */
    public function setLocationInfo(\Netcast\Urest\MainBundle\Entity\LocationInfo $locationInfo = null)
    {
        $this->location_info = $locationInfo;

        return $this;
    }

    /**
     * Get location_info
     *
     * @return \Netcast\Urest\MainBundle\Entity\LocationInfo 
     */
    public function getLocationInfo()
    {
        return $this->location_info;
    }

    /**
     * Set media
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $media
     * @return LocationInfoImage
     */
    public function setMedia(\Application\Sonata\MediaBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }
    /**
     * @var integer
     */
    private $locinfoId;


    /**
     * Set locinfoId
     *
     * @param integer $locinfoId
     * @return LocationInfoImage
     */
    public function setLocinfoId($locinfoId)
    {
        $this->locinfoId = $locinfoId;

        return $this;
    }

    /**
     * Get locinfoId
     *
     * @return integer 
     */
    public function getLocinfoId()
    {
        return $this->locinfoId;
    }
}
