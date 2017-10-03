<?php

namespace Netcast\Urest\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faq
 */
class Faq extends HasI18NEntity
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
     * @var boolean
     */
    private $active;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $updated;


    public function __toString()
    {
        return $this->getContent() ?: '';
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $faq_content;

    protected $contentField = 'faq_content';


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->faq_content = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add faq_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\FaqContent $faq_content
     * @return Faq
     */
    public function addAboutContent(FaqContent $faq_content)
    {
        $this->faq_content[] = $faq_content;

        return $this;
    }

    /**
     * Remove faq_content
     *
     * @param \Netcast\Urest\MainBundle\Entity\FaqContent $faq_content
     */
    public function removeAboutContent(FaqContent $faq_content)
    {
        $this->faq_content->removeElement($faq_content);
    }

    /**
     * Get faq_content
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFaqContent()
    {
        return $this->faq_content;
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
     * @return Faq
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
     * Set active
     *
     * @param boolean $active
     * @return Faq
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
     * Set created
     *
     * @param \DateTime $created
     * @return Faq
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
     * @return Faq
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
     * @var \Application\Sonata\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Faq
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
     * @var \DateTime
     */
    private $datePublish;


    /**
     * Set datePublish
     *
     * @param \DateTime $datePublish
     * @return Faq
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
     * @var boolean
     */
    private $deleted = false;


    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Faq
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
}
