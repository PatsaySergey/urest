<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Options
 */
class Options extends HasI18NEntity
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
     * @var \Netcast\Urest\MainBundle\Entity\Service
     */
    private $service;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $options_content;

    protected $contentField = 'options_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
        $this->options_content = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add options_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\OptionsContent $options_content
     * @return Options
     */
    public function addOptionsContent(OptionsContent $options_content)
    {
        $this->options_content[] = $options_content;

        return $this;
    }

    /**
     * Remove options_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\OptionsContent $options_content
     */
    public function removeOptionsContent(OptionsContent $options_content)
    {
        $this->options_content->removeElement($options_content);
    }

    /**
     * Get options_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptionsContent()
    {
        return $this->options_content;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Options
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
     * @return Options
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
     * @return Options
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
     * @param \Netcast\Urest\MainBundle\Entity\OptionImages $images
     * @return Options
     */
    public function addImage(\Netcast\Urest\MainBundle\Entity\OptionImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Netcast\Urest\MainBundle\Entity\OptionImages $images
     */
    public function removeImage(\Netcast\Urest\MainBundle\Entity\OptionImages $images)
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
     * @return Options
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
     * Set service
     *
     * @param \Netcast\Urest\MainBundle\Entity\Service $service
     * @return Options
     */
    public function setService(\Netcast\Urest\MainBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Netcast\Urest\MainBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Add video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     * @return Options
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

    public function __toString() {
        return $this->getContent() ? $this->getContent()->getTitle() : '';
    }

}
