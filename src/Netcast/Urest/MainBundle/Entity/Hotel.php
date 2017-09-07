<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * Hotel
 */
class Hotel extends HasI18NEntity
{
    /**
     * @var integer
     */
    private $id;


    /**
     * @var integer
     */
    private $stars_count;

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
    private $rooms;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $hotel_content;

    protected $contentField = 'hotel_content';

    protected $active;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hotel_content = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add hotel_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelContent $hotel_content
     * @return Hotel
     */
    public function addHotelContent(\Netcast\Urest\MainBundle\Entity\HotelContent $hotel_content)
    {
        $this->hotel_content[] = $hotel_content;

        return $this;
    }

    /**
     * Remove hotel_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelContent $hotel_content
     */
    public function removeHotelContent(\Netcast\Urest\MainBundle\Entity\HotelContent $hotel_content)
    {
        $this->hotel_content->removeElement($hotel_content);
    }

    /**
     * Get hotel_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHotelContent()
    {
        return $this->hotel_content;
    }

    /**
     * Set stars_count
     *
     * @param integer $starsCount
     * @return Hotel
     */
    public function setStarsCount($starsCount)
    {
        $this->stars_count = $starsCount;

        return $this;
    }

    /**
     * Get stars_count
     *
     * @return integer 
     */
    public function getStarsCount()
    {
        return $this->stars_count;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Hotel
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
     * @return Hotel
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
     * Add rooms
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelRoom $rooms
     * @return Hotel
     */
    public function addRoom(\Netcast\Urest\MainBundle\Entity\HotelRoom $rooms)
    {
        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelRoom $rooms
     */
    public function removeRoom(\Netcast\Urest\MainBundle\Entity\HotelRoom $rooms)
    {
        $this->rooms->removeElement($rooms);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Add images
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelImages $images
     * @return Hotel
     */
    public function addImage(\Netcast\Urest\MainBundle\Entity\HotelImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelImages $images
     */
    public function removeImage(\Netcast\Urest\MainBundle\Entity\HotelImages $images)
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
     * @return Hotel
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
     * @return Hotel
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
     * Add video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     * @return Hotel
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

    public function getMainImage() {
        if(!$this->images) return null;
        foreach ($this->images as $image) {
            if($image->getMain()) return $image;
        }
        return null;
    }

    public function getMinPrice() {
        $price = 0;
        foreach ($this->getRooms() as $rom) {
            if(!$price || $price > $rom->getPrice()) $price = $rom->getPrice();
        }
        return $price;
    }

    public function getMaxPrice() {
        $price = 0;
        foreach ($this->getRooms() as $rom) {
            if(!$price || $price < $rom->getPrice()) $price = $rom->getPrice();
        }
        return $price;
    }

    public function getAddress() {
        $country = $this->getCity()->getRegion()->getCountry();
        $city = $this->getCity();
        return $country->getContent().', '.$city->getContent();
    }

    public function setActive($active) {
        $this->active = $active;

        return  $this;
    }

    public function getActive() {
        return  $this->active;
    }
}
