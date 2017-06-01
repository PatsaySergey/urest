<?php

namespace Netcast\Urest\MainBundle\Entity;


/**
 * BlogCategory
 */
class BlogCategory extends HasI18NEntity
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
    private $posts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $category_content;

    /**
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    protected $contentField = 'category_content';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->category_content = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return BlogCategory
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
     * @return BlogCategory
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
     * Set created
     *
     * @param \DateTime $created
     * @return BlogCategory
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
     * @return BlogCategory
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
     * Add posts
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogPost $posts
     * @return BlogCategory
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

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return BlogCategory
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
     * Add category_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogCategoryContent $categoryContent
     * @return BlogCategory
     */
    public function addCategoryContent(\Netcast\Urest\MainBundle\Entity\BlogCategoryContent $categoryContent)
    {
        $this->category_content[] = $categoryContent;

        return $this;
    }

    /**
     * Remove category_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\BlogCategoryContent $categoryContent
     */
    public function removeCategoryContent(\Netcast\Urest\MainBundle\Entity\BlogCategoryContent $categoryContent)
    {
        $this->category_content->removeElement($categoryContent);
    }

    /**
     * Get category_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryContent()
    {
        return $this->category_content;
    }

}
