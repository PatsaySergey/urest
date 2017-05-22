<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * Tour
 */
class Tour extends HasI18NEntity {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $datePublish;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var string
     */
    private $coordinates;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var boolean
     */
    private $show_in_builder;

    /**
     * @var boolean
     */
    private $hot_offer;


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tour_dates;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $tour_content;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tour_video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tour_images;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\City
     */
    private $city;

    private $removedImages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pay_history;


    private $icon;

    protected $contentField = 'tour_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tour_dates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tour_video = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tour_images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tour_content = new \Doctrine\Common\Collections\ArrayCollection();
        $this->removedImages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set datePublish
     *
     * @param \DateTime $datePublish
     * @return Tour
     */
    public function setDatePublish($datePublish)
    {
        $this->datePublish = $datePublish;

        return $this;
    }

    /**
     * Get datePublish
     *
     * @return \DateTime 
     */
    public function getDatePublish()
    {
        return $this->datePublish;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Tour
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
     * Set coordinates
     *
     * @param string $coordinates
     * @return Tour
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
     * Set active
     *
     * @param boolean $active
     * @return Tour
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
     * Set show_in_builder
     *
     * @param boolean $showInBuilder
     * @return Tour
     */
    public function setShowInBuilder($showInBuilder)
    {
        $this->show_in_builder = $showInBuilder;

        return $this;
    }

    /**
     * Get show_in_builder
     *
     * @return boolean 
     */
    public function getShowInBuilder()
    {
        return $this->show_in_builder;
    }

    /**
     * Set hot_offer
     *
     * @param boolean $hotOffer
     * @return Tour
     */
    public function setHotOffer($hotOffer)
    {
        $this->hot_offer = $hotOffer;

        return $this;
    }

    /**
     * Get hot_offer
     *
     * @return boolean 
     */
    public function getHotOffer()
    {
        return $this->hot_offer;
    }

    /**
     * Add tour_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourContent $tourContent
     * @return Tour
     */
    public function addTourContent(\Netcast\Urest\MainBundle\Entity\TourContent $tourContent)
    {
        $this->tour_content[] = $tourContent;

        return $this;
    }

    /**
     * Remove tour_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourContent $tourContent
     */
    public function removeTourContent(\Netcast\Urest\MainBundle\Entity\TourContent $tourContent)
    {
        $this->tour_content->removeElement($tourContent);
    }

    /**
     * Get tour_contents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTourContent()
    {
        return $this->tour_content;
    }

    /**
     * Add tour_dates
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourDates $tourDates
     * @return Tour
     */
    public function addTourDate(\Netcast\Urest\MainBundle\Entity\TourDates $tourDates)
    {
        $this->tour_dates[] = $tourDates;

        return $this;
    }

    /**
     * Remove tour_dates
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourDates $tourDates
     */
    public function removeTourDate(\Netcast\Urest\MainBundle\Entity\TourDates $tourDates)
    {
        $this->tour_dates->removeElement($tourDates);
    }

    /**
     * Get tour_dates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTourDates()
    {
        return $this->tour_dates;
    }

    /**
     * Add tour_video
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourVideo $tourVideo
     * @return Tour
     */
    public function addTourVideo(\Netcast\Urest\MainBundle\Entity\TourVideo $tourVideo)
    {
        $this->tour_video[] = $tourVideo;

        return $this;
    }

    /**
     * Remove tour_video
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourVideo $tourVideo
     */
    public function removeTourVideo(\Netcast\Urest\MainBundle\Entity\TourVideo $tourVideo)
    {
        $this->tour_video->removeElement($tourVideo);
    }

    /**
     * Get tour_video
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTourVideo()
    {
        return $this->tour_video;
    }

    /**
     * Add tour_images
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourImages $tourImages
     * @return Tour
     */
    public function addTourImage(\Netcast\Urest\MainBundle\Entity\TourImages $tourImages)
    {
        $this->tour_images[] = $tourImages;

        return $this;
    }

    /**
     * Remove tour_images
     *
     * @param \Netcast\Urest\MainBundle\Entity\TourImages $tourImages
     */
    public function removeTourImage(\Netcast\Urest\MainBundle\Entity\TourImages $tourImages)
    {
        $this->removedImages[] = $tourImages;
        $this->tour_images->removeElement($tourImages);
    }

    /**
     * Get tour_images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTourImages()
    {
        return $this->tour_images;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Tour
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
     * Set city
     *
     * @param \Netcast\Urest\MainBundle\Entity\City $city
     * @return Tour
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
     * Set icon
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $icon
     * @return Tour
     */
    public function setIcon(\Application\Sonata\MediaBundle\Entity\Media $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    public function getRemovedImages() {
        return $this->removedImages;
    }

    /**
     * Add payHistory
     *
     * @param \Netcast\Urest\MainBundle\Entity\PayHistory $payHistory
     *
     * @return Tour
     */
    public function addPayHistory(\Netcast\Urest\MainBundle\Entity\PayHistory $payHistory)
    {
        $this->pay_history[] = $payHistory;

        return $this;
    }
/**
     * Remove payHistory
     *
     * @param \Netcast\Urest\MainBundle\Entity\PayHistory $payHistory
     */
    public function removePayHistory(\Netcast\Urest\MainBundle\Entity\PayHistory $payHistory)
    {
        $this->pay_history->removeElement($payHistory);
    }

    /**
     * Get payHistory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayHistory()
    {
        return $this->pay_history;
    }

    public function __toString() {
        return $this->getContent() ? $this->getContent()->getTitle() : '';
    }
}
