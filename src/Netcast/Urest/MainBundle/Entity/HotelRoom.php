<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * HotelRoom
 */
class HotelRoom extends HasI18NEntity
{
    /**
     * @var integer
     */
    private $id;

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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\Hotel
     */
    private $hotel;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $room_content;

    protected $contentField = 'room_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->room_content = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add room_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelRoomContent $room_content
     * @return HotelRoom
     */
    public function addRoomContent(HotelRoomContent $room_content)
    {
        $this->room_content[] = $room_content;

        return $this;
    }

    /**
     * Remove room_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\HotelRoomContent $room_content
     */
    public function removeRoomContent(HotelRoomContent $room_content)
    {
        $this->room_content->removeElement($room_content);
    }

    /**
     * Get room_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoomContent()
    {
        return $this->room_content;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return HotelRoom
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
     * Set created
     *
     * @param \DateTime $created
     * @return HotelRoom
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
     * @return HotelRoom
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
     * @param \Netcast\Urest\MainBundle\Entity\RoomImages $images
     * @return HotelRoom
     */
    public function addImage(\Netcast\Urest\MainBundle\Entity\RoomImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Netcast\Urest\MainBundle\Entity\RoomImages $images
     */
    public function removeImage(\Netcast\Urest\MainBundle\Entity\RoomImages $images)
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
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return HotelRoom
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
     * Set hotel
     *
     * @param \Netcast\Urest\MainBundle\Entity\Hotel $hotel
     * @return HotelRoom
     */
    public function setHotel(\Netcast\Urest\MainBundle\Entity\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Netcast\Urest\MainBundle\Entity\Hotel 
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Add video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     * @return HotelRoom
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

    public function __toString() {
        $title = '';
        $hotel = $this->hotel;
        if(!is_null($hotel)) {
            $title .= $hotel->getContent()->getTitle().' - ';
        }
        if(!is_null($this->getContent())) {
            $title .= $this->getContent()->getTitle();
        }
        return $title;
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
     * @return HotelRoom
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
