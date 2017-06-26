<?php

namespace Netcast\Urest\MainBundle\Entity;


/**
 * Apartment
 */
class Apartment extends HasI18NEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $rooms_count;

    /**
     * @var string
     */
    private $price;

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
    private $images;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\City
     */
    private $city;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\ApartmentType
     */
    private $types;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $apartment_content;

    protected $contentField = 'apartment_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->apartment_content = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add apartment_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\ApartmentContent $apartment_content
     * @return Apartment
     */
    public function addApartmentContent(ApartmentContent $apartment_content)
    {
        $this->apartment_content[] = $apartment_content;

        return $this;
    }

    /**
     * Remove apartment_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\ApartmentContent $apartment_content
     */
    public function removeApartmentContent(ApartmentContent $apartment_content)
    {
        $this->apartment_content->removeElement($apartment_content);
    }

    /**
     * Get apartment_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApartmentContent()
    {
        return $this->apartment_content;
    }

    /**
     * Set rooms_count
     *
     * @param integer $roomsCount
     * @return Apartment
     */
    public function setRoomsCount($roomsCount)
    {
        $this->rooms_count = $roomsCount;

        return $this;
    }

    /**
     * Get rooms_count
     *
     * @return integer 
     */
    public function getRoomsCount()
    {
        return $this->rooms_count;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Apartment
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get Price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Apartment
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
     * @return Apartment
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
     * Add images
     *
     * @param \Netcast\Urest\MainBundle\Entity\ApartmentImages $images
     * @return Apartment
     */
    public function addImage(\Netcast\Urest\MainBundle\Entity\ApartmentImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Netcast\Urest\MainBundle\Entity\ApartmentImages $images
     */
    public function removeImage(\Netcast\Urest\MainBundle\Entity\ApartmentImages $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set city
     *
     * @param \Netcast\Urest\MainBundle\Entity\City $city
     * @return Apartment
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
     * @return Apartment
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
     * Set types
     *
     * @param \Netcast\Urest\MainBundle\Entity\ApartmentType $types
     * @return Apartment
     */
    public function setTypes(\Netcast\Urest\MainBundle\Entity\ApartmentType $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return \Netcast\Urest\MainBundle\Entity\ApartmentType 
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     * @return Apartment
     */
    public function addVideo(\Application\Sonata\MediaBundle\Entity\Media $video=null)
    {
        if($video instanceof \Application\Sonata\MediaBundle\Entity\Media)
            $this->video[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     */
    public function removeVideo(\Application\Sonata\MediaBundle\Entity\Media $video)
    {
        $this->video->removeElement($video);
    }

    /**
     * Get video
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideo()
    {
        return $this->video;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tour;


    /**
     * Add tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour
     *
     * @return Apartment
     */
    public function addTour(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour)
    {
        $this->tour[] = $tour;

        return $this;
    }

    /**
     * Remove tour
     *
     * @param \Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour
     */
    public function removeTour(\Netcast\Urest\MainBundle\Entity\CustomTourOrder $tour)
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
}
