<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationInfo
 */
class LocationInfo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $preview_text;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var \DateTime
     */
    private $datePublish;

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
    private $locationinfo_image;

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
    private $children;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\LocationInfo
     */
    private $parent;


    public function __toString()
    {
        return $this->title ?: '';
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
     * Set title
     *
     * @param string $title
     * @return LocationInfo
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
     * Set lang
     *
     * @param string $lang
     * @return LocationInfo
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
     * Set alias
     *
     * @param string $alias
     * @return LocationInfo
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return LocationInfo
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set preview_text
     *
     * @param string $previewText
     * @return LocationInfo
     */
    public function setPreviewText($previewText)
    {
        $this->preview_text = $previewText;

        return $this;
    }

    /**
     * Get preview_text
     *
     * @return string 
     */
    public function getPreviewText()
    {
        return $this->preview_text;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return LocationInfo
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
     * Set datePublish
     *
     * @param \DateTime $datePublish
     * @return LocationInfo
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
     * @return LocationInfo
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
     * @return LocationInfo
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
     * Add locationinfo_image
     *
     * @param \Netcast\Urest\MainBundle\Entity\LocationInfoImage $locationinfoImage
     * @return LocationInfo
     */
    public function addLocationinfoImage(\Netcast\Urest\MainBundle\Entity\LocationInfoImage $locationinfoImage)
    {
        $this->locationinfo_image[] = $locationinfoImage;

        return $this;
    }

    /**
     * Remove locationinfo_image
     *
     * @param \Netcast\Urest\MainBundle\Entity\LocationInfoImage $locationinfoImage
     */
    public function removeLocationinfoImage(\Netcast\Urest\MainBundle\Entity\LocationInfoImage $locationinfoImage)
    {
        $this->locationinfo_image->removeElement($locationinfoImage);
    }

    /**
     * Get locationinfo_image
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocationinfoImage()
    {
        return $this->locationinfo_image;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return LocationInfo
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
     * Set preview_image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $previewImage
     * @return LocationInfo
     */
    public function setPreviewImage(\Application\Sonata\MediaBundle\Entity\Media $previewImage = null)
    {
        $this->preview_image = $previewImage;

        return $this;
    }

    /**
     * Get preview_image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getPreviewImage()
    {
        return $this->preview_image;
    }

    /**
     * Add video
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $video
     * @return LocationInfo
     */
    public function addVideo(\Application\Sonata\MediaBundle\Entity\Media $video = null)
    {
        if ($video instanceof \Application\Sonata\MediaBundle\Entity\Media)
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
     * Add children
     *
     * @param \Netcast\Urest\MainBundle\Entity\LocationInfo $children
     * @return LocationInfo
     */
    public function addChild(\Netcast\Urest\MainBundle\Entity\LocationInfo $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Netcast\Urest\MainBundle\Entity\LocationInfo $children
     */
    public function removeChild(\Netcast\Urest\MainBundle\Entity\LocationInfo $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Netcast\Urest\MainBundle\Entity\LocationInfo $parent
     * @return LocationInfo
     */
    public function setParent(\Netcast\Urest\MainBundle\Entity\LocationInfo $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Netcast\Urest\MainBundle\Entity\LocationInfo 
     */
    public function getParent()
    {
        return $this->parent;
    }





    /**
     * Constructor
     */
    public function __construct()
    {
        $this->locationinfo_image = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var string
     */
    private $coordinates;


    /**
     * Set coordinates
     *
     * @param string $coordinates
     * @return LocationInfo
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
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $icon;


    /**
     * Set icon
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $icon
     * @return LocationInfo
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
}
