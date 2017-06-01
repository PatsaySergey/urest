<?php

namespace Netcast\Urest\MainBundle\Entity;

/**
 * BlogTag
 */
class BlogTag extends HasI18NEntity
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
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var integer
     */
    private $frequency;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $posts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $tag_content;

    protected $contentField = 'tag_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag_content = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tag_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogTagContent $tag_content
     * @return BlogTag
     */
    public function addTagContent(\Netcast\Urest\MainBundle\Entity\BlogTagContent $tag_content)
    {
        $this->tag_content[] = $tag_content;

        return $this;
    }

    /**
     * Remove tag_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogTagContent $categoryContent
     */
    public function removeTagContent(\Netcast\Urest\MainBundle\Entity\BlogTagContent $categoryContent)
    {
        $this->tag_content->removeElement($categoryContent);
    }

    /**
     * Get tag_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTagContent()
    {
        return $this->tag_content;
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
     * @return BlogTag
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
     * Set created
     *
     * @param \DateTime $created
     * @return BlogTag
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
     * @return BlogTag
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
     * Set frequency
     *
     * @param integer $frequency
     * @return BlogTag
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return BlogTag
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
     * Add posts
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPost $posts
     * @return BlogTag
     */
    public function addPost(\Netcast\Urest\MainBundle\Entity\BlogPost $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPost $posts
     */
    public function removePost(\Netcast\Urest\MainBundle\Entity\BlogPost $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
