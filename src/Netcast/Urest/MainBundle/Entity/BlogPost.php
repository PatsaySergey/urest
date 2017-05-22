<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPost
 */
class BlogPost extends HasI18NEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $alias;


    /**
     * @var string
     */
    private $coordinates;

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
    private $video;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $images;

    /**
     * @var \Netcast\Urest\MainBundle\Entity\BlogCategory
     */
    private $category;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     */
    private $locator_icon;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tags;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $post_content;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->post_content = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->getContent() ? $this->getContent()->getTitle() : '';
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
     * Set userId
     *
     * @param integer $userId
     * @return BlogPost
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return BlogPost
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
     * Set coordinates
     *
     * @param string $coordinates
     * @return BlogPost
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
     * @return BlogPost
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
     * @return BlogPost
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
     * @return BlogPost
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
     * @return BlogPost
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
     * Add video
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPostVideo $video
     * @return BlogPost
     */
    public function addVideo(\Netcast\Urest\MainBundle\Entity\BlogPostVideo $video)
    {
        $this->video[] = $video;

        return $this;
    }

    /**
     * Remove video
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPostVideo $video
     */
    public function removeVideo(\Netcast\Urest\MainBundle\Entity\BlogPostVideo $video)
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
     * Add images
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPostImages $images
     * @return BlogPost
     */
    public function addImage(\Netcast\Urest\MainBundle\Entity\BlogPostImages $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPostImages $images
     */
    public function removeImage(\Netcast\Urest\MainBundle\Entity\BlogPostImages $images)
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
     * Set category
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogCategory $category
     * @return BlogPost
     */
    public function setCategory(\Netcast\Urest\MainBundle\Entity\BlogCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Netcast\Urest\MainBundle\Entity\BlogCategory 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return BlogPost
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
     * Set locator_icon
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $locatorIcon
     * @return BlogPost
     */
    public function setLocatorIcon(\Application\Sonata\MediaBundle\Entity\Media $locatorIcon = null)
    {
        $this->locator_icon = $locatorIcon;

        return $this;
    }

    /**
     * Get locator_icon
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getLocatorIcon()
    {
        return $this->locator_icon;
    }

    /**
     * Add tags
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogTag $tags
     * @return BlogPost
     */
    public function addTag(\Netcast\Urest\MainBundle\Entity\BlogTag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogTag $tags
     */
    public function removeTag(\Netcast\Urest\MainBundle\Entity\BlogTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
    /**
     * @var boolean
     */
    private $deleted = false;


    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return BlogPost
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Add post_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPostContent $postContent
     * @return BlogPost
     */
    public function addPostContent(\Netcast\Urest\MainBundle\Entity\BlogPostContent $postContent)
    {
        $this->post_content[] = $postContent;

        return $this;
    }

    /**
     * Remove post_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPostContent $postContent
     */
    public function removePostContent(\Netcast\Urest\MainBundle\Entity\BlogPostContent $postContent)
    {
        $this->post_content->removeElement($postContent);
    }

    /**
     * Get post_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostContent()
    {
        return $this->post_content;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('lang', $this->currentLocale))
        ;
        $content = $this->post_content->matching($criteria);

        if($content->count() > 0) return $content->first();
        $criteria->where(Criteria::expr()->eq('lang', $this->defaultLocale));
        $content = $this->post_content->matching($criteria);
        if($content->count()) return $content->first();
    }
}
